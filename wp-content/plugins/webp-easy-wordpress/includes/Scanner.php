<?php

declare(strict_types=1);

namespace Lever\WebPMigrator;

final class Scanner
{
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return array<string,mixed>
     */
    public function fullScan(): array
    {
        $this->logger->info('Iniciando scan completo.');

        $attachments = $this->scanMediaLibrary();
        $contentRefs = $this->scanPostContent();
        $metaRefs = $this->scanPostMeta();
        $acfRefs = $this->scanAcf();

        $summary = [
            'timestamp' => time(),
            'attachment_ids' => $attachments,
            'attachments_count' => count($attachments),
            'post_content' => $contentRefs,
            'post_meta' => $metaRefs,
            'acf' => $acfRefs,
        ];

        $this->logger->info('Scan concluído.', [
            'attachments' => $summary['attachments_count'],
            'content_urls' => $summary['post_content']['urls_count'],
            'meta_urls' => $summary['post_meta']['urls_count'],
            'acf_urls' => $summary['acf']['urls_count'],
        ]);

        return $summary;
    }

    /**
     * @return array<int,int>
     */
    public function scanMediaLibrary(): array
    {
        $args = [
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query' => [
                [
                    'key' => '_wp_attached_file',
                    'compare' => 'EXISTS',
                ],
            ],
        ];

        $ids = get_posts($args);
        if (! is_array($ids)) {
            return [];
        }

        $supported = [];
        foreach ($ids as $id) {
            $file = get_attached_file((int) $id);
            if (! $file || ! is_file($file)) {
                continue;
            }

            $ext = strtolower((string) pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
                $supported[] = (int) $id;
            }
        }

        return $supported;
    }

    /**
     * @return array<string,mixed>
     */
    public function scanPostContent(): array
    {
        global $wpdb;

        $posts = $wpdb->get_results(
            "SELECT ID, post_content FROM {$wpdb->posts} WHERE post_status NOT IN ('trash', 'auto-draft')",
            ARRAY_A
        );

        $urls = [];
        $ids = [];

        foreach ((array) $posts as $post) {
            $content = (string) ($post['post_content'] ?? '');
            if ($content === '') {
                continue;
            }

            $foundUrls = Utils::filterSupportedImageUrls(Utils::extractUrls($content));
            foreach ($foundUrls as $url) {
                $urls[$url] = true;
            }

            if (preg_match_all('/wp-image-([0-9]+)/', $content, $matches)) {
                foreach ($matches[1] as $attachmentId) {
                    $ids[(int) $attachmentId] = true;
                }
            }
        }

        return [
            'urls' => array_keys($urls),
            'urls_count' => count($urls),
            'attachment_ids' => array_map('intval', array_keys($ids)),
            'attachment_ids_count' => count($ids),
        ];
    }

    /**
     * @return array<string,mixed>
     */
    public function scanPostMeta(): array
    {
        global $wpdb;

        $rows = $wpdb->get_results(
            "SELECT meta_id, post_id, meta_key, meta_value FROM {$wpdb->postmeta}",
            ARRAY_A
        );

        $urls = [];
        $keys = [];

        foreach ((array) $rows as $row) {
            $keys[(string) $row['meta_key']] = true;
            $value = maybe_unserialize($row['meta_value']);
            $this->collectFromAny($value, $urls);
        }

        return [
            'meta_keys_count' => count($keys),
            'urls' => array_keys($urls),
            'urls_count' => count($urls),
        ];
    }

    /**
     * @return array<string,mixed>
     */
    public function scanAcf(): array
    {
        if (! function_exists('acf_get_field_groups') || ! function_exists('acf_get_fields')) {
            return [
                'enabled' => false,
                'field_groups_count' => 0,
                'urls' => [],
                'urls_count' => 0,
                'attachment_ids' => [],
                'attachment_ids_count' => 0,
            ];
        }

        $groups = acf_get_field_groups();
        $urls = [];
        $ids = [];

        $posts = get_posts([
            'post_type' => 'any',
            'post_status' => 'any',
            'posts_per_page' => -1,
            'fields' => 'ids',
        ]);

        foreach ((array) $posts as $postId) {
            $fieldObjects = function_exists('get_field_objects') ? get_field_objects((int) $postId, false, true) : null;
            if (! is_array($fieldObjects)) {
                continue;
            }

            foreach ($fieldObjects as $field) {
                $this->collectFromAcfField($field, $urls, $ids);
            }
        }

        return [
            'enabled' => true,
            'field_groups_count' => count((array) $groups),
            'urls' => array_keys($urls),
            'urls_count' => count($urls),
            'attachment_ids' => array_map('intval', array_keys($ids)),
            'attachment_ids_count' => count($ids),
        ];
    }

    /**
     * @param mixed $value
     * @param array<string,bool> $urls
     */
    private function collectFromAny($value, array &$urls): void
    {
        if (is_string($value)) {
            foreach (Utils::filterSupportedImageUrls(Utils::extractUrls($value)) as $url) {
                $urls[$url] = true;
            }

            return;
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                $this->collectFromAny($item, $urls);
            }

            return;
        }

        if (is_object($value)) {
            foreach ($value as $item) {
                $this->collectFromAny($item, $urls);
            }
        }
    }

    /**
     * @param array<string,mixed> $field
     * @param array<string,bool> $urls
     * @param array<int|string,bool> $ids
     */
    private function collectFromAcfField(array $field, array &$urls, array &$ids): void
    {
        $type = (string) ($field['type'] ?? '');
        $value = $field['value'] ?? null;

        if (in_array($type, ['image', 'gallery'], true)) {
            $this->collectAcfImageValue($value, $urls, $ids);
        } else {
            $this->collectFromAny($value, $urls);
        }

        if (! empty($field['sub_fields']) && is_array($field['sub_fields'])) {
            foreach ($field['sub_fields'] as $subField) {
                if (is_array($subField)) {
                    $this->collectFromAcfField($subField, $urls, $ids);
                }
            }
        }
    }

    /**
     * @param mixed $value
     * @param array<string,bool> $urls
     * @param array<int|string,bool> $ids
     */
    private function collectAcfImageValue($value, array &$urls, array &$ids): void
    {
        if (is_numeric($value)) {
            $ids[(int) $value] = true;
            return;
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                $this->collectAcfImageValue($item, $urls, $ids);
            }

            if (! empty($value['url']) && is_string($value['url']) && Utils::isSupportedImageUrl($value['url'])) {
                $urls[$value['url']] = true;
            }

            if (! empty($value['ID']) && is_numeric($value['ID'])) {
                $ids[(int) $value['ID']] = true;
            }
        }
    }
}
