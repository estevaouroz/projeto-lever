<?php

namespace Src\handlers;

use WP_User;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handler especializado em eventos de usuários administradores
 */
class UserHandler extends BaseHandler {

    public function handle_registration(int $user_id) {
        if (!$this->is_enabled('admin_created')) {
            return;
        }

        $user = get_userdata($user_id);
        if (!$this->is_admin($user)) {
            return;
        }

        $info = $this->format_user_info($user);

        $mensagem = "------\n👤 **CRIAÇÃO DE ADMINISTRADOR NO SITE**\n\n"
                  . $info . "\n"
                  . "Site: " . home_url() . "\n"
                  . "Data: " . current_time('d/m/Y H:i')."\n\n";

        $this->send($mensagem);
    }

    public function handle_deletion($user) {
        if (!$this->is_enabled('admin_deleted')) {
            return;
        }
        
        if (!$user instanceof WP_User || !$this->is_admin($user)) {
            return;
        }

        $info = $this->format_user_info($user);

        $mensagem = "------\n🗑️ **EXCLUSÃO DE ADMINISTRADOR NO SITE**\n\n"
                  . $info . "\n"
                  . "Site: " . home_url() . "\n"
                  . "Data: " . current_time('d/m/Y H:i')."\n\n";

        $this->send($mensagem);
    }

    private function is_admin($user): bool {
        return $user && in_array('administrator', (array) $user->roles, true);
    }

    private function format_user_info(WP_User $user): string {
        return "• **Nome:** {$user->display_name}\n"
             . "• **Email:** {$user->user_email}\n"
             . "• **Login:** {$user->user_login}";
    }

    protected function get_color(): int {
        return 15158332;
    }
}