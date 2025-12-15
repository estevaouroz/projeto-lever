<?php

namespace Src;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Classe responsável pelo envio de mensagens ao Discord (SRP puro).
 */
class Notifier {

    /**
     * Obtém a URL do webhook (prioridade: constante > opção salva).
     *
     * @return string URL do webhook ou string vazia se não configurada.
     */
    public function get_webhook_url() {
        if (defined('DISCORD_WEBHOOK_URL') && DISCORD_WEBHOOK_URL !== 'example.com' && DISCORD_WEBHOOK_URL !== '') {
            return DISCORD_WEBHOOK_URL;
        }
        return get_option('dzn_discord_webhook_url', '');
    }

    /**
     * Obtém o nome do bot (prioridade: constante > opção salva > default).
     *
     * @return string Nome do bot.
     */
    public function get_bot_name() {
        if (defined('DISCORD_BOT_NAME') && !empty(DISCORD_BOT_NAME)) {
            return DISCORD_BOT_NAME;
        }
        $saved_name = get_option('dzn_discord_bot_name', '');
        return !empty($saved_name) ? $saved_name : 'Spidey Bot';  // Fallback para default
    }

    /**
     * Envia uma mensagem ao Discord.
     *
     * @param string $message Mensagem principal (content).
     * @param array  $embed   Embed opcional.
     */
    public function send($message, $embed = []) {
        $webhook_url = $this->get_webhook_url();
        if (empty($webhook_url)) {
            error_log('Discord Notifications: Webhook URL não configurado.');
            return;
        }

        $payload = [
            'username'   => $this->get_bot_name(),  // ← Use o nome dinâmico aqui
            'avatar_url' => 'https://wordpress.org/favicon.ico',
            'content'    => $message,
        ];

        if (!empty($embed)) {
            $payload['embeds'] = [$embed];
        }

        $response = wp_remote_post($webhook_url, [
            'method'  => 'POST',
            'headers' => ['Content-Type' => 'application/json'],
            'body'    => wp_json_encode($payload),
            'timeout' => 10,
        ]);

        if (is_wp_error($response)) {
            error_log('Discord Notifications erro: ' . $response->get_error_message());
        }
    }
}