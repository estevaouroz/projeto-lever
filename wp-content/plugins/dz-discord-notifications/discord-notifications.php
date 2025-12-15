<?php
/**
 * Plugin Name: Discord Notifications
 * Description: Envia notificações para Discord sobre atualizações de plugins, ativação/desativação/exclusão e criação/exclusão de administradores.
 * Version: 1.2 (Refatorado Multi-arquivos)
 * Author: Dzigual
 * Text Domain: discord-notifications
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define o caminho base do plugin (útil para includes)
define('DZN_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Carrega o autoloader do Composer
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// Inicializa o plugin quando todos os plugins forem carregados
add_action('plugins_loaded', function () {
    new \Src\Main();
});