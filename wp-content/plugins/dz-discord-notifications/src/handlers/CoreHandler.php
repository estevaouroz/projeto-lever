<?php

namespace Src\handlers;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handler especializado em atualizações do core WordPress
 */
class CoreHandler extends BaseHandler {

    public function handle_update() {
        if (!$this->is_enabled('core_update')) return;

        $version = get_bloginfo('version');
        $message = "\n------\n WORDPRESS ATUALIZADO PARA A VERSÃO **{$version}** \n------\n ";

        $this->send_embed($message, 'ATUALIZAÇÃO DO CORE');
    }

    protected function get_color(): int {
        return 2067276; // Verde para core updates
    }
}
