<?php

namespace Src\Admin;

use Src\Notifier;

if (!defined('ABSPATH')) {
    exit;
}

class Settings {

    private Notifier $notifier;

    public function __construct(Notifier $notifier) {
        $this->notifier = $notifier;
    }

    public function is_settings_page_visible() {
        return ! (defined('DISCORD_NOTIFICATIONS_HIDE_SETTINGS') && DISCORD_NOTIFICATIONS_HIDE_SETTINGS);
    }

    public function register_admin_hooks() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_post_dzn_test_webhook', [$this, 'handle_test_webhook']);
    }

    public function add_admin_menu() {
        add_options_page(
            __('Discord Notifications', 'discord-notifications'),
            __('Discord Notifications', 'discord-notifications'),
            'manage_options',
            'dzn-discord-notifications',
            [$this, 'render_settings_page']
        );
    }

    public function register_settings() {
        register_setting('dzn_discord_group', 'dzn_discord_webhook_url', ['sanitize_callback' => 'esc_url_raw']);
        register_setting('dzn_discord_group', 'dzn_discord_alerts');

        add_settings_section('dzn_main_section', __('Configurações principais', 'discord-notifications'), null, 'dzn-discord-notifications');

        add_settings_field('webhook_url', __('Webhook URL do Discord', 'discord-notifications'), [$this, 'field_webhook_url'], 'dzn-discord-notifications', 'dzn_main_section');
        add_settings_field('alerts',       __('Alertas que deseja receber', 'discord-notifications'), [$this, 'field_alerts'],       'dzn-discord-notifications', 'dzn_main_section');
    }

    public function field_webhook_url() {
        $value = $this->notifier->get_webhook_url();
        echo '<input type="url" name="dzn_discord_webhook_url" value="' . esc_attr($value) . '" class="regular-text" />';
        echo '<p class="description">' . __('Cole aqui a URL completa do webhook do Discord.', 'discord-notifications') . '</p>';

        if (defined('DISCORD_WEBHOOK_URL') && DISCORD_WEBHOOK_URL !== 'example.com' && DISCORD_WEBHOOK_URL !== '') {
            echo '<p class="description" style="color:#d63638;"><strong>Atenção:</strong> Webhook definido via constante no wp-config.php (campo ignorado).</p>';
        }
    }

    public function field_alerts() {
        $options = get_option('dzn_discord_alerts', [
            'plugin_update'      => '1',
            'plugin_activate'    => '1',
            'plugin_deactivate'  => '1',
            'plugin_delete'      => '1',
            'core_update'        => '1',
            'admin_created'      => '1',
            'admin_deleted'      => '1',
        ]);

        $alerts = [
            'plugin_update'      => __('Atualização de plugin', 'discord-notifications'),
            'plugin_activate'    => __('Ativação de plugin', 'discord-notifications'),
            'plugin_deactivate'  => __('Desativação de plugin', 'discord-notifications'),
            'plugin_delete'      => __('Exclusão de plugin', 'discord-notifications'),
            'core_update'        => __('Atualização do core WordPress', 'discord-notifications'),
            'admin_created'      => __('Novo administrador criado', 'discord-notifications'),
            'admin_deleted'      => __('Administrador excluído', 'discord-notifications'),
        ];

        foreach ($alerts as $key => $label) {
            $checked_value = isset($options[$key]) ? $options[$key] : '';
            $checked = checked($checked_value, '1', false);
            echo '<label><input type="checkbox" name="dzn_discord_alerts[' . $key . ']" value="1" ' . $checked . '> ' . $label . '</label><br>';
        }
    }

    public function render_settings_page() {
        if (isset($_GET['dzn_test']) && $_GET['dzn_test'] === 'success') {
            echo '<div class="notice notice-success is-dismissible"><p>' . __('Mensagem de teste enviada com sucesso!', 'discord-notifications') . '</p></div>';
        }

        ?>
        <div class="wrap">
            <h1><?php _e('Discord Notifications', 'discord-notifications'); ?></h1>

            <form method="post" action="options.php">
                <?php
                settings_fields('dzn_discord_group');
                do_settings_sections('dzn-discord-notifications');
                submit_button();
                ?>
            </form>

            <h2><?php _e('Testar webhook', 'discord-notifications'); ?></h2>
            <form method="post" action="admin-post.php">
                <?php wp_nonce_field('dzn_test_webhook', 'dzn_test_nonce'); ?>
                <input type="hidden" name="action" value="dzn_test_webhook">
                <?php submit_button(__('Enviar mensagem de teste', 'discord-notifications'), 'secondary'); ?>
            </form>
        </div>
        <?php
    }

    public function handle_test_webhook() {
        check_admin_referer('dzn_test_webhook', 'dzn_test_nonce');

        if (!current_user_can('manage_options')) {
            wp_die(__('Permissão insuficiente.', 'discord-notifications'));
        }

        $this->notifier->send("🧪 **Mensagem de teste do Discord Notifications**\nFuncionando corretamente! ✅\nSite: " . home_url());

        wp_redirect(add_query_arg('dzn_test', 'success', wp_get_referer()));
        exit;
    }

    public function get_alerts_config() {
        $options = get_option('dzn_discord_alerts', []);
        $defaults = [
            'plugin_update'      => false,
            'plugin_activate'    => false,
            'plugin_deactivate'  => false,
            'plugin_delete'      => false,
            'core_update'        => false,
            'admin_created'      => false,
            'admin_deleted'      => false,
        ];
        $bool_options = array();
        foreach ($options as $k => $v) {
            $bool_options[$k] = !empty($v);
        }
        return array_merge($defaults, $bool_options);
    }
}