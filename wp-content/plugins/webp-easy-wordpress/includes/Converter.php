<?php

declare(strict_types=1);

namespace Lever\WebPMigrator;

final class Converter
{
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param array<int,int> $attachmentIds
     * @return array<string,mixed>
     */
    public function convertBatch(array $attachmentIds, int $quality = 85, bool $dryRun = false): array
    {
        $result = [
            'processed' => 0,
            'converted' => 0,
            'simulated' => 0,
            'skipped' => 0,
            'errors' => 0,
            'url_map' => [],
        ];

        foreach ($attachmentIds as $attachmentId) {
            $result['processed']++;
            try {
                $single = $this->convertAttachment((int) $attachmentId, $quality, $dryRun);
            } catch (\Throwable $e) {
                $this->logger->error('Exceção ao converter imagem', [
                    'attachment_id' => (int) $attachmentId,
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);

                $single = ['error' => 'Exceção durante conversão'];
            }

            if (! empty($single['converted'])) {
                $result['converted']++;
            } elseif (! empty($single['simulated'])) {
                $result['simulated']++;
            } elseif (! empty($single['error'])) {
                $result['errors']++;
            } else {
                $result['skipped']++;
            }

            if (! empty($single['url_map']) && is_array($single['url_map'])) {
                foreach ($single['url_map'] as $from => $to) {
                    $result['url_map'][$from] = $to;
                }
            }
        }

        return $result;
    }

    /**
     * @return array<string,mixed>
     */
    public function convertAttachment(int $attachmentId, int $quality = 85, bool $dryRun = false): array
    {
        $file = get_attached_file($attachmentId);
        if (! $file || ! is_file($file)) {
            return ['error' => 'Arquivo não encontrado'];
        }

        $ext = strtolower((string) pathinfo($file, PATHINFO_EXTENSION));
        if (! in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
            return ['skipped' => true];
        }

        $metadata = wp_get_attachment_metadata($attachmentId);
        if (! is_array($metadata)) {
            $metadata = [];
        }

        $webpFull = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file);
        if (! is_string($webpFull)) {
            return ['error' => 'Falha ao calcular nome WebP'];
        }

        if ($dryRun) {
            return [
                'simulated' => true,
                'url_map' => $this->buildUrlMap($attachmentId, $file, $webpFull, $metadata),
            ];
        }

        $conversion = $this->convertFileToWebp($file, $webpFull, $quality);
        if (empty($conversion['success'])) {
            $this->logger->error('Erro ao converter imagem', [
                'attachment_id' => $attachmentId,
                'file' => $file,
                'reason' => $conversion['error'] ?? 'erro desconhecido',
            ]);
            return ['error' => 'Falha na conversão'];
        }

        $sizeMap = $this->generateWebpSizes($file, $metadata, $quality);
        $this->saveWebpMetadata($attachmentId, $webpFull, $sizeMap, $metadata);

        $urlMap = $this->buildUrlMap($attachmentId, $file, $webpFull, $metadata, $sizeMap);

        $this->logger->info('Imagem convertida para WebP', ['attachment_id' => $attachmentId, 'file' => $file]);

        return [
            'converted' => true,
            'url_map' => $urlMap,
        ];
    }

    /**
     * @return array{success:bool,error:string}
     */
    private function convertFileToWebp(string $source, string $target, int $quality): array
    {
        if (extension_loaded('imagick') && class_exists('Imagick')) {
            try {
                $image = new \Imagick($source);
                $image->setImageFormat('webp');
                $image->setImageCompressionQuality($quality);
                $ok = $image->writeImage($target);
                $image->clear();
                $image->destroy();
                if ((bool) $ok && is_file($target)) {
                    return ['success' => true, 'error' => ''];
                }
            } catch (\Throwable $e) {
                $this->logger->error('Imagick falhou, fallback para GD', ['message' => $e->getMessage()]);
            }
        }

        if (! function_exists('imagewebp')) {
            return ['success' => false, 'error' => 'Função imagewebp indisponível'];
        }

        $mime = '';
        if (function_exists('wp_get_image_mime')) {
            $mime = (string) wp_get_image_mime($source);
        }

        if ($mime === '' && function_exists('getimagesize')) {
            $sizeData = @getimagesize($source);
            if (is_array($sizeData) && ! empty($sizeData['mime'])) {
                $mime = (string) $sizeData['mime'];
            }
        }

        if ($mime === '') {
            $ext = strtolower((string) pathinfo($source, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg'], true)) {
                $mime = 'image/jpeg';
            } elseif ($ext === 'png') {
                $mime = 'image/png';
            }
        }

        if (($mime === 'image/jpeg' || $mime === 'image/jpg') && function_exists('imagecreatefromjpeg')) {
            $resource = @imagecreatefromjpeg($source);
        } elseif ($mime === 'image/png' && function_exists('imagecreatefrompng')) {
            $resource = @imagecreatefrompng($source);
            if ($resource) {
                imagepalettetotruecolor($resource);
                imagealphablending($resource, true);
                imagesavealpha($resource, true);
            }
        } else {
            return ['success' => false, 'error' => 'Tipo de imagem não suportado para GD: ' . $mime];
        }

        if (! $resource) {
            return ['success' => false, 'error' => 'Falha ao criar recurso GD'];
        }

        $ok = imagewebp($resource, $target, $quality);
        imagedestroy($resource);

        if (! (bool) $ok || ! is_file($target)) {
            return ['success' => false, 'error' => 'GD não conseguiu salvar WebP'];
        }

        return ['success' => true, 'error' => ''];
    }

    /**
     * @param array<string,mixed> $metadata
     * @return array<string,string>
     */
    private function generateWebpSizes(string $fullFile, array $metadata, int $quality): array
    {
        if (empty($metadata['sizes']) || ! is_array($metadata['sizes'])) {
            return [];
        }

        $baseDir = trailingslashit((string) dirname($fullFile));
        $sizes = [];

        foreach ($metadata['sizes'] as $sizeName => $sizeData) {
            if (empty($sizeData['file']) || ! is_string($sizeData['file'])) {
                continue;
            }

            $sizeFile = $baseDir . $sizeData['file'];
            if (! is_file($sizeFile)) {
                continue;
            }

            $target = preg_replace('/\.(jpe?g|png)$/i', '.webp', $sizeFile);
            if (! is_string($target)) {
                continue;
            }

            $sizeConversion = $this->convertFileToWebp($sizeFile, $target, $quality);
            if (! empty($sizeConversion['success'])) {
                $sizes[(string) $sizeName] = wp_basename($target);
            }
        }

        return $sizes;
    }

    /**
     * @param array<string,string> $sizeMap
     * @param array<string,mixed> $metadata
     */
    private function saveWebpMetadata(int $attachmentId, string $webpFull, array $sizeMap, array $metadata): void
    {
        $relativeBase = (string) get_post_meta($attachmentId, '_wp_attached_file', true);
        $relativeFull = preg_replace('/\.(jpe?g|png)$/i', '.webp', $relativeBase);

        if (! is_string($relativeFull)) {
            return;
        }

        $webpSizes = [];
        foreach ($sizeMap as $size => $fileName) {
            if (! empty($metadata['sizes'][$size]['file']) && is_string($metadata['sizes'][$size]['file'])) {
                $webpSizes[$size] = str_replace($metadata['sizes'][$size]['file'], $fileName, $relativeBase);
            }
        }

        $metadata['webp'] = [
            'full' => $relativeFull,
            'sizes' => $webpSizes,
            'generated_at' => time(),
        ];

        update_post_meta($attachmentId, '_wp_attachment_metadata', $metadata);
        update_post_meta($attachmentId, '_lwm_webp_file', $relativeFull);
    }

    /**
     * @param array<string,mixed> $metadata
     * @param array<string,string> $sizeMap
     * @return array<string,string>
     */
    private function buildUrlMap(int $attachmentId, string $originalFile, string $webpFile, array $metadata, array $sizeMap = []): array
    {
        $map = [];
        $originalUrl = wp_get_attachment_url($attachmentId);

        if (is_string($originalUrl) && $originalUrl !== '') {
            $map[$originalUrl] = preg_replace('/\.(jpe?g|png)$/i', '.webp', $originalUrl) ?: $originalUrl;
        }

        if (! empty($metadata['sizes']) && is_array($metadata['sizes'])) {
            $uploads = wp_upload_dir();
            $relativeBase = (string) get_post_meta($attachmentId, '_wp_attached_file', true);
            $dir = ltrim((string) dirname($relativeBase), './');

            foreach ($metadata['sizes'] as $sizeName => $sizeData) {
                if (empty($sizeData['file']) || ! is_string($sizeData['file'])) {
                    continue;
                }

                $baseUrl = trailingslashit((string) $uploads['baseurl']);
                $old = $baseUrl . ($dir !== '' && $dir !== '.' ? trailingslashit($dir) : '') . $sizeData['file'];

                if (! empty($sizeMap[$sizeName])) {
                    $new = $baseUrl . ($dir !== '' && $dir !== '.' ? trailingslashit($dir) : '') . $sizeMap[$sizeName];
                } else {
                    $new = preg_replace('/\.(jpe?g|png)$/i', '.webp', $old) ?: $old;
                }

                $map[$old] = $new;
            }
        }

        return $map;
    }
}
