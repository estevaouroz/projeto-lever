<?php

namespace Src\handlers;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handler especializado em atualizações do core WordPress
 */
class CoreHandler extends BaseHandler {

    public function handle_update($new_version = null) {  // ← Adicione parâmetro opcional
        if (!$this->is_enabled('core_update')) return;

        // Debounce para evitar duplicatas (envio apenas uma vez por minuto)
        if (get_transient('discord_core_update_sent')) {
            return;  // Já enviado recentemente, ignore
        }
        set_transient('discord_core_update_sent', true, 60);  // Marca como enviado por 60 segundos

        // Use a nova versão se disponível, senão fallback para get_bloginfo
        $version = $new_version ?: get_bloginfo('version');

        $message = "------\n🔄 **ATUALIZAÇÃO DO CORE WORDPRESS**\n"
                 . "WordPress atualizado para a versão **{$version}**\n"
                 . "Site: " . home_url() . "\n"
                 . "Data: " . current_time('d/m/Y H:i') . "\n------\n";

        $this->send($message);
    }

    protected function get_color(): int {
        return 2067276; // Verde para core updates (pode remover se não usar embed)
    }
}