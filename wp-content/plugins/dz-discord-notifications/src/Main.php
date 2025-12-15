<?php

namespace Src;

use Src\Notifier;
use Src\admin\Settings;
use Src\handlers\HandlerRegistry;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Classe principal - apenas orquestra e delega
 */
class Main {

    private Notifier $notifier; 
    private Settings $settings;
    private HandlerRegistry $handler_registry;

    public function __construct() {
        $this->notifier = new Notifier();    
        $this->settings = new Settings($this->notifier);
        
        // Inicializa o registry que gerencia todos os handlers
        $this->handler_registry = new HandlerRegistry(
            $this->notifier,
            $this->settings->get_alerts_config()
        );
        
        $this->register_hooks();
    }

    private function register_hooks() {
        if ($this->settings->is_settings_page_visible()) {
            $this->settings->register_admin_hooks();
        }

        // Hooks delegados ao registry
        add_action('upgrader_process_complete', [$this->handler_registry, 'handle_upgrader'], 10, 2);
        add_action('activate_plugin',           [$this->handler_registry, 'handle_plugin_activation'], 10, 2);
        add_action('deactivate_plugin',         [$this->handler_registry, 'handle_plugin_deactivation'], 10, 2);
        add_action('user_register',             [$this->handler_registry, 'handle_user_registration']);
        add_action('delete_user',               [$this->handler_registry, 'handle_user_deletion'], 10, 3);
    }
}