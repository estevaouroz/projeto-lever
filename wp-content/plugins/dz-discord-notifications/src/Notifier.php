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
    public function get_webhook_url() {  // ← mudou de private para public
        if (defined('DISCORD_WEBHOOK_URL') && DISCORD_WEBHOOK_URL !== 'example.com' && DISCORD_WEBHOOK_URL !== '') {
            return DISCORD_WEBHOOK_URL;
        }
        return get_option('dzn_discord_webhook_url', '');
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
            'username'   => 'Spidey Bot',
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