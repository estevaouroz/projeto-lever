<?php

namespace Src\handlers;

use Src\Notifier;
use Src\handlers\PluginHandler;
use Src\handlers\CoreHandler;
use Src\handlers\UserHandler;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registry central - roteia eventos para handlers específicos
 */
class HandlerRegistry {

    private PluginHandler $plugin_handler;
    private CoreHandler $core_handler;
    private UserHandler $user_handler;

    public function __construct(Notifier $notifier, array $alerts_config) {
        $this->plugin_handler = new PluginHandler($notifier, $alerts_config);
        $this->core_handler   = new CoreHandler($notifier, $alerts_config);
        $this->user_handler   = new UserHandler($notifier, $alerts_config);
    }

    /**
     * Roteador para eventos do upgrader
     */
    public function handle_upgrader($upgrader, $options) {
        if (!isset($options['action'], $options['type'])) return;

        if ($options['action'] === 'update') {
            $this->route_update($options);
        } elseif ($options['action'] === 'delete' && $options['type'] === 'plugin') {
            $this->plugin_handler->handle_delete($options['plugins'] ?? []);
        }
    }

    private function route_update($options) {
        switch ($options['type']) {
            case 'plugin':
                $this->plugin_handler->handle_update($options['plugins'] ?? []);
                break;
            case 'core':
                $this->core_handler->handle_update();
                break;
        }
    }

    public function handle_plugin_activation($plugin, $network_wide = false) {
        $this->plugin_handler->handle_activation($plugin);
    }

    public function handle_plugin_deactivation($plugin, $network_wide = false) {
        $this->plugin_handler->handle_deactivation($plugin);
    }

    public function handle_user_registration($user_id) {
        $this->user_handler->handle_registration($user_id);
    }

    public function handle_user_deletion($id, $reassign, $user) {
        $this->user_handler->handle_deletion($user);
    }
}
