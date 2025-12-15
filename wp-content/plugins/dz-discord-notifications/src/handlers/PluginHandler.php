<?php

namespace Src\handlers;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handler especializado em eventos de plugins
 */
class PluginHandler extends BaseHandler {

    public function handle_update(array $plugins) {
        if (!$this->is_enabled('plugin_update') || empty($plugins)) return;

        $list = $this->format_plugin_list($plugins);
        $this->send_embed($list, 'Plugins Atualizados', '🔄');
    }

    public function handle_delete(array $plugins) {
        if (!$this->is_enabled('plugin_delete') || empty($plugins)) return;

        $list = $this->format_plugin_list($plugins);
        $this->send("\n------\n **PLUGIN EXCLUÍDO**\n{$list}\n------\n");
    }

    public function handle_activation(string $plugin) {
        if (!$this->is_enabled('plugin_activate')) return;

        $data = $this->get_plugin_data($plugin);
        $this->send("\n------\n **PLUGIN ATIVADO** {$data['Name']} (v{$data['Version']}) \n------\n");
    }

    public function handle_deactivation(string $plugin) {
        if (!$this->is_enabled('plugin_deactivate')) return;

        $data = $this->get_plugin_data($plugin);
        $this->send("\n------\n **PLUGIN DESATIVADO:** {$data['Name']} (v{$data['Version']}) \n------\n");
    }

    // --- Métodos auxiliares ---

    private function format_plugin_list(array $plugins): string {
        $list = array_map(function($plugin) {
            $data = $this->get_plugin_data($plugin);
            return "• {$data['Name']} (v{$data['Version']})";
        }, $plugins);

        return implode("\n", $list);
    }

    private function get_plugin_data(string $plugin): array {
        return get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
    }

    protected function get_color(): int {
        return 5793266;
    }
}
