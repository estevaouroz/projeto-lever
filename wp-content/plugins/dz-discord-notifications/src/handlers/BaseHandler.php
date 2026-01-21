<?php

namespace Src\handlers;

use Src\Notifier;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Classe base para todos os handlers - reutiliza lógica comum
 */
abstract class BaseHandler {

    protected Notifier $notifier;
    protected array $alerts_config;

    public function __construct(Notifier $notifier, array $alerts_config) {
        $this->notifier = $notifier;
        $this->alerts_config = $alerts_config;
    }

    /**
     * Verifica se o alerta está habilitado
     */
    protected function is_enabled(string $alert_key): bool {
        return $this->alerts_config[$alert_key] ?? false;
    }

    /**
     * Envia mensagem simples
     */
    protected function send(string $message) {
        $this->notifier->send($message);
    }

    /**
     * Envia com embed padronizado
     */
    protected function send_embed(string $message, string $title, string $emoji = '📢') {
        $embed = [
            'title'       => "{$emoji} {$title} - " . get_bloginfo('name'),
            'description' => $message . "\n\n**Site:** " . home_url() . "\n**Data:** " . current_time('d/m/Y H:i'),
            'color'       => $this->get_color(),
            'footer'      => ['text' => 'Discord Notifications Plugin'],
            'timestamp'   => current_time('iso8601'),
        ];

        $this->notifier->send('', $embed);
    }

    /**
     * Cor padrão do embed (pode ser sobrescrita)
     */
    protected function get_color(): int {
        return 3447003; // Azul padrão
    }
}