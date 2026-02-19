<?php

declare(strict_types=1);

namespace Lever\WebPMigrator;

final class Logger
{
    private string $filePath;

    public function __construct()
    {
        $uploads = wp_upload_dir();
        $dir = trailingslashit((string) $uploads['basedir']) . 'lever-webp-migrator-logs';
        if (! is_dir($dir)) {
            wp_mkdir_p($dir);
        }

        $this->filePath = trailingslashit($dir) . 'migration.log';
    }

    /**
     * @param array<string,mixed> $context
     */
    public function info(string $message, array $context = []): void
    {
        $this->write('INFO', $message, $context);
    }

    /**
     * @param array<string,mixed> $context
     */
    public function error(string $message, array $context = []): void
    {
        $this->write('ERROR', $message, $context);
    }

    public function tail(int $lines = 200): string
    {
        if (! is_file($this->filePath)) {
            return '';
        }

        $content = (string) file_get_contents($this->filePath);
        $parts = explode("\n", $content);
        $slice = array_slice($parts, -1 * max(1, $lines));

        return trim(implode("\n", $slice));
    }

    /**
     * @param array<string,mixed> $context
     */
    private function write(string $level, string $message, array $context = []): void
    {
        $line = sprintf(
            "[%s] [%s] %s %s\n",
            gmdate('Y-m-d H:i:s'),
            $level,
            $message,
            $context !== [] ? wp_json_encode($context) : ''
        );

        error_log($line, 3, $this->filePath);
    }
}
