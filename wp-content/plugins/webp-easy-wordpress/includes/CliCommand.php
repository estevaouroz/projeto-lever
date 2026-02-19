<?php

declare(strict_types=1);

namespace Lever\WebPMigrator;

final class CliCommand
{
    private Scanner $scanner;

    private Converter $converter;

    private ReferenceUpdater $updater;

    private Logger $logger;

    public function __construct(Scanner $scanner, Converter $converter, ReferenceUpdater $updater, Logger $logger)
    {
        $this->scanner = $scanner;
        $this->converter = $converter;
        $this->updater = $updater;
        $this->logger = $logger;
    }

    /**
     * Executa scan e conversão em lotes.
     *
     * ## OPTIONS
     *
     * [--batch=<number>]
     * : Tamanho do lote. Padrão 25.
     *
     * [--quality=<number>]
     * : Qualidade WebP entre 1 e 100. Padrão 85.
     *
     * [--dry-run]
     * : Simula operação sem persistir alterações.
     *
     * [--network]
     * : Em multisite, processa todos os sites.
     */
    public function convert(array $args, array $assocArgs): void
    {
        $batch = isset($assocArgs['batch']) ? max(1, (int) $assocArgs['batch']) : 25;
        $quality = isset($assocArgs['quality']) ? max(1, min(100, (int) $assocArgs['quality'])) : 85;
        $dryRun = isset($assocArgs['dry-run']);
        $network = isset($assocArgs['network']) && is_multisite();

        if ($network) {
            $siteIds = get_sites(['fields' => 'ids']);
            foreach ($siteIds as $siteId) {
                switch_to_blog((int) $siteId);
                \WP_CLI::log('Processando site #' . (int) $siteId);
                $this->runForCurrentSite($batch, $quality, $dryRun);
                restore_current_blog();
            }

            \WP_CLI::success('Processamento de rede concluído.');
            return;
        }

        $this->runForCurrentSite($batch, $quality, $dryRun);
        \WP_CLI::success('Processamento concluído.');
    }

    private function runForCurrentSite(int $batch, int $quality, bool $dryRun): void
    {
        $scan = $this->scanner->fullScan();
        $ids = array_map('intval', (array) ($scan['attachment_ids'] ?? []));

        $urlMap = [];
        $total = count($ids);
        $processed = 0;

        while ($processed < $total) {
            $slice = array_slice($ids, $processed, $batch);
            $result = $this->converter->convertBatch($slice, $quality, $dryRun);

            foreach ((array) $result['url_map'] as $from => $to) {
                $urlMap[(string) $from] = (string) $to;
            }

            $processed += count($slice);
            \WP_CLI::log(sprintf('Imagens: %d/%d', $processed, $total));
        }

        $this->replaceAllInBatches($urlMap, $dryRun);
    }

    /**
     * @param array<string,string> $urlMap
     */
    private function replaceAllInBatches(array $urlMap, bool $dryRun): void
    {
        $postOffset = 0;
        do {
            $res = $this->updater->replacePostContentBatch($urlMap, $postOffset, 100, $dryRun);
            $postOffset = (int) $res['next_offset'];
            \WP_CLI::log('Post content batch processado: ' . $postOffset);
        } while (empty($res['finished']));

        $metaOffset = 0;
        do {
            $res = $this->updater->replacePostMetaBatch($urlMap, $metaOffset, 500, $dryRun);
            $metaOffset = (int) $res['next_offset'];
            \WP_CLI::log('Post meta batch processado: ' . $metaOffset);
        } while (empty($res['finished']));

        $updatedAttachments = $this->updater->updateAttachmentMetadataReferences($urlMap, $dryRun);
        $this->logger->info('WP-CLI finalizou atualização', ['updated_attachments' => $updatedAttachments]);
    }
}
