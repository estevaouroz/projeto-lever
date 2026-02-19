<?php

declare(strict_types=1);

namespace Lever\WebPMigrator;

final class Plugin
{
    public const OPTION_SCAN = 'lwm_scan_result';
    public const OPTION_JOB = 'lwm_job_state';

    private Logger $logger;

    private Scanner $scanner;

    private Converter $converter;

    private ReferenceUpdater $updater;

    private AdminPage $admin;

    public function __construct()
    {
        $this->logger = new Logger();
        $this->scanner = new Scanner($this->logger);
        $this->converter = new Converter($this->logger);
        $this->updater = new ReferenceUpdater($this->logger);
        $this->admin = new AdminPage($this->scanner, $this->converter, $this->updater, $this->logger);
    }

    public function init(): void
    {
        add_action('admin_menu', [$this->admin, 'registerMenu']);
        add_action('admin_enqueue_scripts', [$this->admin, 'enqueueAssets']);

        add_action('wp_ajax_lwm_scan', [$this->admin, 'ajaxScan']);
        add_action('wp_ajax_lwm_run_batch', [$this->admin, 'ajaxRunBatch']);
        add_action('wp_ajax_lwm_get_log', [$this->admin, 'ajaxGetLog']);

        add_filter('wp_get_attachment_url', [$this, 'filterAttachmentUrl'], 20, 2);
        add_filter('wp_get_attachment_image_src', [$this, 'filterAttachmentImageSrc'], 20, 4);
        add_filter('wp_prepare_attachment_for_js', [$this, 'filterAttachmentForJs'], 20, 3);

        if (defined('WP_CLI') && WP_CLI) {
            \WP_CLI::add_command('lever-webp', new CliCommand($this->scanner, $this->converter, $this->updater, $this->logger));
        }
    }

    public static function activate(bool $networkWide = false): void
    {
        if (is_multisite() && $networkWide) {
            $sites = get_sites(['fields' => 'ids']);
            foreach ($sites as $siteId) {
                switch_to_blog((int) $siteId);
                add_option(self::OPTION_SCAN, []);
                add_option(self::OPTION_JOB, []);
                restore_current_blog();
            }

            return;
        }

        add_option(self::OPTION_SCAN, []);
        add_option(self::OPTION_JOB, []);
    }

    public static function deactivate(bool $networkWide = false): void
    {
        if (is_multisite() && $networkWide) {
            $sites = get_sites(['fields' => 'ids']);
            foreach ($sites as $siteId) {
                switch_to_blog((int) $siteId);
                delete_option(self::OPTION_JOB);
                restore_current_blog();
            }

            return;
        }

        delete_option(self::OPTION_JOB);
    }

    public function filterAttachmentUrl(string $url, int $postId): string
    {
        $meta = wp_get_attachment_metadata($postId);
        if (! is_array($meta) || empty($meta['webp']['full'])) {
            return $url;
        }

        $uploads = wp_upload_dir();
        if (empty($uploads['baseurl'])) {
            return $url;
        }

        return trailingslashit($uploads['baseurl']) . ltrim((string) $meta['webp']['full'], '/');
    }

    public function filterAttachmentImageSrc($image, int $attachmentId, $size, bool $icon)
    {
        if (! is_array($image) || empty($image[0])) {
            return $image;
        }

        $meta = wp_get_attachment_metadata($attachmentId);
        if (! is_array($meta) || empty($meta['webp'])) {
            return $image;
        }

        $uploads = wp_upload_dir();
        if (empty($uploads['baseurl'])) {
            return $image;
        }

        if (is_string($size) && isset($meta['webp']['sizes'][$size])) {
            $image[0] = trailingslashit($uploads['baseurl']) . ltrim((string) $meta['webp']['sizes'][$size], '/');
            return $image;
        }

        if (! is_string($size) && ! empty($meta['webp']['full'])) {
            $image[0] = trailingslashit($uploads['baseurl']) . ltrim((string) $meta['webp']['full'], '/');
        }

        return $image;
    }

    /**
     * @param array<string,mixed> $response
     * @param \WP_Post $attachment
     * @param array<string,mixed> $meta
     * @return array<string,mixed>
     */
    public function filterAttachmentForJs(array $response, \WP_Post $attachment, array $meta): array
    {
        if (empty($meta['webp']) || ! is_array($meta['webp'])) {
            return $response;
        }

        $uploads = wp_upload_dir();
        $baseurl = trailingslashit((string) ($uploads['baseurl'] ?? ''));
        if ($baseurl === '') {
            return $response;
        }

        if (! empty($meta['webp']['full']) && is_string($meta['webp']['full'])) {
            $response['url'] = $baseurl . ltrim($meta['webp']['full'], '/');

            $webpFilename = wp_basename($meta['webp']['full']);
            if ($webpFilename !== '') {
                $response['filename'] = $webpFilename;
            }
        }

        if (! empty($response['sizes']) && is_array($response['sizes']) && ! empty($meta['webp']['sizes']) && is_array($meta['webp']['sizes'])) {
            foreach ($response['sizes'] as $sizeName => $sizeData) {
                if (! is_array($sizeData)) {
                    continue;
                }

                if (! empty($meta['webp']['sizes'][$sizeName]) && is_string($meta['webp']['sizes'][$sizeName])) {
                    $response['sizes'][$sizeName]['url'] = $baseurl . ltrim($meta['webp']['sizes'][$sizeName], '/');
                }
            }
        }

        return $response;
    }
}
