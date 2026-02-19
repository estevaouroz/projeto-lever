<?php

declare(strict_types=1);

namespace Lever\WebPMigrator;

final class Utils
{
    /**
     * @param mixed $value
     * @param array<string,string> $map
     * @return mixed
     */
    public static function replaceInValue($value, array $map, bool &$changed)
    {
        if (is_string($value)) {
            $replaced = strtr($value, $map);
            if ($replaced !== $value) {
                $changed = true;
            }

            return $replaced;
        }

        if (is_array($value)) {
            foreach ($value as $key => $item) {
                $value[$key] = self::replaceInValue($item, $map, $changed);
            }

            return $value;
        }

        if (is_object($value)) {
            foreach ($value as $key => $item) {
                $value->{$key} = self::replaceInValue($item, $map, $changed);
            }
        }

        return $value;
    }

    /**
     * @return array<int,string>
     */
    public static function extractUrls(string $content): array
    {
        if ($content === '') {
            return [];
        }

        preg_match_all('#https?://[^\s"\'<>]+#i', $content, $matches);
        if (empty($matches[0])) {
            return [];
        }

        return array_values(array_unique(array_map('esc_url_raw', $matches[0])));
    }

    public static function isSupportedImageUrl(string $url): bool
    {
        $path = (string) wp_parse_url($url, PHP_URL_PATH);
        return (bool) preg_match('/\.(jpe?g|png)$/i', $path);
    }

    /**
     * @param array<int,string> $urls
     * @return array<int,string>
     */
    public static function filterSupportedImageUrls(array $urls): array
    {
        return array_values(array_filter($urls, [self::class, 'isSupportedImageUrl']));
    }
}
