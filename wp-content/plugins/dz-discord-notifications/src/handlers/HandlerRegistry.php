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
        if (!isset($options['action']) || $options['action'] !== 'update') {
            return;
        }

        $this->route_update($options);
    }

    private function route_update($options) {
        switch ($options['type']) {
            case 'plugin':
                if (isset($options['plugins']) && is_array($options['plugins']) && !empty($options['plugins'])) {
                    $plugins = $options['plugins'];
                } elseif (isset($options['plugin']) && $options['plugin']) {
                    $plugins = [$options['plugin']];
                } else {
                    return;
                }

                $this->plugin_handler->handle_update($plugins);
                break;

            case 'core':
                $this->core_handler->handle_update(null);  // ← Passe null aqui (versão não disponível diretamente)
                break;
        }
    }

    public function handle_core_updated_successfully($new_version) {
        $this->core_handler->handle_update($new_version);  // ← Passe a nova versão aqui
    }

    public function handle_plugin_activation($plugin, $network_wide = false) {
        $this->plugin_handler->handle_activation($plugin);
    }

    public function handle_plugin_deactivation($plugin, $network_wide = false) {
        $this->plugin_handler->handle_deactivation($plugin);
    }

    public function handle_plugin_deleted($plugin_file, $deleted) {
        if ($deleted) {
            $this->plugin_handler->handle_delete([$plugin_file]);
        }
    }

    public function handle_user_registration($user_id) {
        $this->user_handler->handle_registration($user_id);
    }
    

    public function handle_user_deletion($id, $reassign, $user) {
        $this->user_handler->handle_deletion($user);
    }
}
