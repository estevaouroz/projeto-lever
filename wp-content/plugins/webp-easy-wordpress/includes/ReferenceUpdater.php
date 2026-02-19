<?php

declare(strict_types=1);

namespace Lever\WebPMigrator;

final class ReferenceUpdater
{
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param array<string,string> $urlMap
     * @return array<string,int>
     */
    public function replacePostContentBatch(array $urlMap, int $offset = 0, int $limit = 50, bool $dryRun = false): array
    {
        global $wpdb;

        if ($urlMap === []) {
            return ['processed' => 0, 'updated' => 0, 'next_offset' => $offset, 'finished' => 1];
        }

        $posts = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT ID, post_content FROM {$wpdb->posts} WHERE post_status NOT IN ('trash', 'auto-draft') ORDER BY ID ASC LIMIT %d OFFSET %d",
                $limit,
                $offset
            ),
            ARRAY_A
        );

        $processed = 0;
        $updated = 0;

        foreach ((array) $posts as $post) {
            $processed++;
            $old = (string) ($post['post_content'] ?? '');
            $new = strtr($old, $urlMap);

            if ($new !== $old) {
                $updated++;
                if (! $dryRun) {
                    wp_update_post([
                        'ID' => (int) $post['ID'],
                        'post_content' => $new,
                    ]);
                }
            }
        }

        $finished = count((array) $posts) < $limit ? 1 : 0;
        return [
            'processed' => $processed,
            'updated' => $updated,
            'next_offset' => $offset + $processed,
            'finished' => $finished,
        ];
    }

    /**
     * @param array<string,string> $urlMap
     * @return array<string,int>
     */
    public function replacePostMetaBatch(array $urlMap, int $offset = 0, int $limit = 200, bool $dryRun = false): array
    {
        global $wpdb;

        if ($urlMap === []) {
            return ['processed' => 0, 'updated' => 0, 'next_offset' => $offset, 'finished' => 1];
        }

        $rows = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT meta_id, meta_value FROM {$wpdb->postmeta} ORDER BY meta_id ASC LIMIT %d OFFSET %d",
                $limit,
                $offset
            ),
            ARRAY_A
        );

        $processed = 0;
        $updated = 0;

        foreach ((array) $rows as $row) {
            $processed++;
            $metaId = (int) ($row['meta_id'] ?? 0);
            $originalRaw = $row['meta_value'];
            $value = maybe_unserialize($originalRaw);

            $changed = false;
            $newValue = Utils::replaceInValue($value, $urlMap, $changed);

            if (! $changed) {
                continue;
            }

            $updated++;
            if (! $dryRun) {
                $wpdb->update(
                    $wpdb->postmeta,
                    ['meta_value' => maybe_serialize($newValue)],
                    ['meta_id' => $metaId],
                    ['%s'],
                    ['%d']
                );
            }
        }

        $finished = count((array) $rows) < $limit ? 1 : 0;
        return [
            'processed' => $processed,
            'updated' => $updated,
            'next_offset' => $offset + $processed,
            'finished' => $finished,
        ];
    }

    /**
     * @param array<string,string> $urlMap
     */
    public function updateAttachmentMetadataReferences(array $urlMap, bool $dryRun = false): int
    {
        $ids = get_posts([
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => -1,
            'fields' => 'ids',
        ]);

        $updated = 0;
        foreach ((array) $ids as $id) {
            $meta = wp_get_attachment_metadata((int) $id);
            if (! is_array($meta)) {
                continue;
            }

            $changed = false;
            $newMeta = Utils::replaceInValue($meta, $urlMap, $changed);
            if (! $changed) {
                continue;
            }

            $updated++;
            if (! $dryRun) {
                update_post_meta((int) $id, '_wp_attachment_metadata', $newMeta);
            }
        }

        if ($updated > 0) {
            $this->logger->info('Metadados de anexos atualizados', ['count' => $updated]);
        }

        return $updated;
    }
}
