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
        if (!$this->is_enabled('plugin_update') || empty($plugins)) {
            return;
        }

        $list = $this->format_plugin_list($plugins);

        $mensagem = "------\n🔄 **ATUALIZAÇÃO DE PLUGINS NO SITE**\n"
                  . $list . " - versão atual\n"
                  . "Site: " . home_url() . "\n"
                  . "Data: " . current_time('d/m/Y H:i')."\n\n";

        $this->send($mensagem);
    }

    public function handle_delete(array $plugins) {
        if (!$this->is_enabled('plugin_delete') || empty($plugins)) {
            return;
        }

        $list = $this->format_plugin_list($plugins);

        $mensagem = "------\n🗑️ **EXCLUSÃO DE PLUGINS NO SITE**\n"
                  . $list . "\n"
                  . "Site: " . home_url() . "\n"
                  . "Data: " . current_time('d/m/Y H:i')."\n\n";

        $this->send($mensagem);
    }

    public function handle_activation(string $plugin) {
        if (!$this->is_enabled('plugin_activate')) {
            return;
        }

        $list = $this->format_plugin_list([$plugin]);

        $mensagem = "------\n✅ **ATIVAÇÃO DE PLUGIN NO SITE**\n"
                  . $list . "\n"
                  . "Site: " . home_url() . "\n"
                  . "Data: " . current_time('d/m/Y H:i')."\n\n";

        $this->send($mensagem);
    }

    public function handle_deactivation(string $plugin) {
        if (!$this->is_enabled('plugin_deactivate')) {
            return;
        }

        $list = $this->format_plugin_list([$plugin]);

        $mensagem = "------\n❌ **DESATIVAÇÃO DE PLUGIN NO SITE**\n"
                  . $list . "\n"
                  . "Site: " . home_url() . "\n"
                  . "Data: " . current_time('d/m/Y H:i')."\n\n";

        $this->send($mensagem);
    }

    // --- Métodos auxiliares (mantidos iguais) ---
    private function format_plugin_list(array $plugins): string {
        $list = array_map(function($plugin) {
            $data = $this->get_plugin_data($plugin);

            // Fallback se o arquivo não existir mais (exclusão)
            $name = $data['Name'] 
                ? $data['Name'] 
                : ucwords(str_replace(['-', '_'], ' ', basename(dirname($plugin))));

            $version = $data['Version'] ?? '';

            return "• {$name}" . ($version ? " (v{$version})" : '');
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