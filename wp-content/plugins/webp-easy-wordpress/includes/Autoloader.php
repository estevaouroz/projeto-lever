<?php

declare(strict_types=1);

namespace Lever\WebPMigrator;

final class Autoloader
{
    public static function register(): void
    {
        spl_autoload_register(static function (string $class): void {
            $prefix = __NAMESPACE__ . '\\';
            if (strpos($class, $prefix) !== 0) {
                return;
            }

            $relative = substr($class, strlen($prefix));
            $file = LWM_PLUGIN_DIR . 'includes/' . str_replace('\\', '/', $relative) . '.php';
            if (is_readable($file)) {
                require_once $file;
            }
        });
    }
}
