<?php

declare(strict_types=1);

namespace Lever\WebPMigrator;

final class AdminPage
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

    public function registerMenu(): void
    {
        add_menu_page(
            'WebP Easy WordPress',
            'WebP Easy WordPress',
            'manage_options',
            'webp-easy-wordpress',
            [$this, 'renderPage'],
            'dashicons-format-image',
            58
        );
    }

    public function enqueueAssets(string $hook): void
    {
        if ($hook !== 'toplevel_page_webp-easy-wordpress') {
            return;
        }

        wp_enqueue_script(
            'lwm-admin',
            LWM_PLUGIN_URL . 'assets/admin.js',
            ['jquery'],
            LWM_VERSION,
            true
        );

        wp_localize_script('lwm-admin', 'LWM_ADMIN', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('lwm_nonce'),
        ]);
    }

    public function renderPage(): void
    {
        if (! current_user_can('manage_options')) {
            wp_die(esc_html__('Sem permissão para acessar esta página.', 'webp-easy-wordpress'));
        }

        $scan = get_option(Plugin::OPTION_SCAN, []);
        ?>
        <div class="wrap">
            <h1>WebP Easy WordPress</h1>
            <p>Escaneia referências (Media Library, conteúdo, ACF/meta) e converte imagens em lotes para WebP.</p>

            <label>
                <input type="checkbox" id="lwm-dry-run" value="1" />
                Executar em modo Dry-run (sem persistir alterações)
            </label>
            <p><em>Com Dry-run ativo, nenhum arquivo .webp é criado e nenhuma URL é alterada.</em></p>

            <p>
                <button class="button button-secondary" id="lwm-scan-btn">Scan</button>
                <button class="button button-primary" id="lwm-convert-btn">Convert</button>
            </p>

            <div style="max-width: 720px; background: #f0f0f1; border: 1px solid #dcdcde; height: 24px;">
                <div id="lwm-progress-bar" style="width:0%;height:100%;background:#2271b1;"></div>
            </div>
            <p id="lwm-progress-label">Aguardando...</p>

            <h2>Resumo do último scan</h2>
            <pre id="lwm-scan-summary"><?php echo esc_html(wp_json_encode($scan, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)); ?></pre>

            <h2>Log</h2>
            <pre id="lwm-log" style="max-height:260px;overflow:auto;background:#1e1e1e;color:#e9e9e9;padding:12px;"><?php echo esc_html($this->logger->tail()); ?></pre>
        </div>
        <?php
    }

    public function ajaxScan(): void
    {
        $this->assertPermission();

        $scan = $this->scanner->fullScan();
        update_option(Plugin::OPTION_SCAN, $scan, false);

        $job = [
            'stage' => 'idle',
            'dry_run' => false,
            'quality' => 85,
            'attachment_ids' => $scan['attachment_ids'] ?? [],
            'attachment_cursor' => 0,
            'post_cursor' => 0,
            'meta_cursor' => 0,
            'url_map' => [],
            'stats' => [
                'converted' => 0,
                'simulated' => 0,
                'processed_images' => 0,
                'post_updates' => 0,
                'meta_updates' => 0,
                'errors' => 0,
            ],
            'started_at' => time(),
        ];

        update_option(Plugin::OPTION_JOB, $job, false);

        wp_send_json_success([
            'scan' => $scan,
            'job' => $job,
        ]);
    }

    public function ajaxRunBatch(): void
    {
        try {
            $this->assertPermission();

            $dryRun = ! empty($_POST['dry_run']);
            $batch = isset($_POST['batch']) ? max(1, (int) $_POST['batch']) : 20;
            $quality = isset($_POST['quality']) ? max(1, min(100, (int) $_POST['quality'])) : 85;

            $job = get_option(Plugin::OPTION_JOB, []);
            if (! is_array($job) || empty($job['attachment_ids'])) {
                wp_send_json_error(['message' => 'Execute o scan primeiro.']);
            }

            $job['dry_run'] = $dryRun;
            $job['quality'] = $quality;
            $job['stage'] = $job['stage'] ?? 'converting';

            if ($job['stage'] === 'idle') {
                $job['stage'] = 'converting';
                if ($dryRun) {
                    $this->logger->info('Conversão iniciada em modo Dry-run (simulação sem persistência).');
                } else {
                    $this->logger->info('Conversão iniciada em modo real (persistindo alterações).');
                }
            }

            if ($job['stage'] === 'converting') {
                $slice = array_slice((array) $job['attachment_ids'], (int) $job['attachment_cursor'], $batch);
                $result = $this->converter->convertBatch(array_map('intval', $slice), $quality, $dryRun);

                $job['attachment_cursor'] = (int) $job['attachment_cursor'] + count($slice);
                $job['stats']['processed_images'] = (int) $job['stats']['processed_images'] + (int) $result['processed'];
                $job['stats']['converted'] = (int) $job['stats']['converted'] + (int) $result['converted'];
                $job['stats']['simulated'] = (int) ($job['stats']['simulated'] ?? 0) + (int) ($result['simulated'] ?? 0);
                $job['stats']['errors'] = (int) $job['stats']['errors'] + (int) $result['errors'];

                foreach ((array) $result['url_map'] as $from => $to) {
                    $job['url_map'][(string) $from] = (string) $to;
                }

                if ((int) $job['attachment_cursor'] >= count((array) $job['attachment_ids'])) {
                    $job['stage'] = 'replacing_posts';
                }

                update_option(Plugin::OPTION_JOB, $job, false);
                wp_send_json_success($this->jobResponse($job));
            }

            if ($job['stage'] === 'replacing_posts') {
                $result = $this->updater->replacePostContentBatch(
                    (array) $job['url_map'],
                    (int) $job['post_cursor'],
                    50,
                    $dryRun
                );

                $job['post_cursor'] = (int) $result['next_offset'];
                $job['stats']['post_updates'] = (int) $job['stats']['post_updates'] + (int) $result['updated'];

                if (! empty($result['finished'])) {
                    $job['stage'] = 'replacing_meta';
                }

                update_option(Plugin::OPTION_JOB, $job, false);
                wp_send_json_success($this->jobResponse($job));
            }

            if ($job['stage'] === 'replacing_meta') {
                $result = $this->updater->replacePostMetaBatch(
                    (array) $job['url_map'],
                    (int) $job['meta_cursor'],
                    200,
                    $dryRun
                );

                $job['meta_cursor'] = (int) $result['next_offset'];
                $job['stats']['meta_updates'] = (int) $job['stats']['meta_updates'] + (int) $result['updated'];

                if (! empty($result['finished'])) {
                    $this->updater->updateAttachmentMetadataReferences((array) $job['url_map'], $dryRun);
                    $job['stage'] = 'done';
                    $job['finished_at'] = time();
                    $this->logger->info('Processo concluído', ['stats' => $job['stats']]);
                }

                update_option(Plugin::OPTION_JOB, $job, false);
                wp_send_json_success($this->jobResponse($job));
            }

            wp_send_json_success($this->jobResponse($job));
        } catch (\Throwable $e) {
            $this->logger->error('Falha no processamento em lote', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            wp_send_json_error([
                'message' => 'Falha interna no processamento em lote.',
                'reason' => $e->getMessage(),
            ], 500);
        }
    }

    public function ajaxGetLog(): void
    {
        $this->assertPermission();
        wp_send_json_success([
            'log' => $this->logger->tail(),
        ]);
    }

    private function assertPermission(): void
    {
        check_ajax_referer('lwm_nonce', 'nonce');

        if (! current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Sem permissão'], 403);
        }
    }

    /**
     * @param array<string,mixed> $job
     * @return array<string,mixed>
     */
    private function jobResponse(array $job): array
    {
        $total = max(1, count((array) ($job['attachment_ids'] ?? [])));
        $attachmentCursor = (int) ($job['attachment_cursor'] ?? 0);
        $baseProgress = min(60, (int) floor(($attachmentCursor / $total) * 60));

        $stage = (string) ($job['stage'] ?? 'idle');
        $progress = $baseProgress;
        if ($stage === 'replacing_posts') {
            $progress = 70;
        } elseif ($stage === 'replacing_meta') {
            $progress = 90;
        } elseif ($stage === 'done') {
            $progress = 100;
        }

        return [
            'job' => $job,
            'stage' => $stage,
            'progress' => $progress,
        ];
    }
}
