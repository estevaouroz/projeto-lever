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
        if (!$this->is_enabled('admin_created')) return;

        $user = get_userdata($user_id);
        if (!$this->is_admin($user)) return;

        $message = $this->format_user_info($user);
        $this->send("\n------\n **NOVO ADMINISTRADOR ADICIONADO**\n{$message} \n------\n");
    }

    public function handle_deletion($user) {
        if (!$this->is_enabled('admin_deleted')) return;
        
        if (!$user instanceof WP_User || !$this->is_admin($user)) return;

        $message = $this->format_user_info($user);
        $this->send("\n------\n **ADMINISTRADOR EXCLUÍDO**\n{$message} \n------\n");
    }

    private function is_admin($user): bool {
        return $user && in_array('administrator', (array) $user->roles, true);
    }

    private function format_user_info(WP_User $user): string {
        return "**Nome:** {$user->display_name}\n"
             . "**Email:** {$user->user_email}\n"
             . "**Login:** {$user->user_login}";
    }

    protected function get_color(): int {
        return 15158332;
    }
}