<?php
/**
 * Plugin Name: WebP Easy WordPress
 * Description: Escaneia referências de imagens (Media Library, conteúdo, ACF e meta), converte JPG/PNG para WebP e atualiza referências com segurança.
 * Version: 1.0.0
 * Author: WebP Easy WordPress
 * Requires at least: 6.4
 * Requires PHP: 7.4
 * Text Domain: webp-easy-wordpress
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
    exit;
}

define('LWM_VERSION', '1.0.0');
define('LWM_PLUGIN_FILE', __FILE__);
define('LWM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LWM_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once LWM_PLUGIN_DIR . 'includes/Autoloader.php';

Lever\WebPMigrator\Autoloader::register();

$plugin = new Lever\WebPMigrator\Plugin();
$plugin->init();

register_activation_hook(__FILE__, [Lever\WebPMigrator\Plugin::class, 'activate']);
register_deactivation_hook(__FILE__, [Lever\WebPMigrator\Plugin::class, 'deactivate']);
