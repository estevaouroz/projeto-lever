# Discord Notifications (WordPress Plugin)

Plugin desenvolvido para integrar o WordPress ao Discord via Webhook. Ele monitora eventos críticos do sistema (atualizações, segurança e administração) e envia alertas em tempo real para um canal configurado.

## 🏗️ Ecossistema e Arquitetura

Este projeto foi construído seguindo os padrões de engenharia de software modernos aplicados ao WordPress.

### Boilerplate DZigual
A estrutura base de projeto utilizada para a construção do plugin foi **DZigual Boilerplate 2024**,  onde se pode ter mais informações sobre o mesmo abaixo.

* **Referência do Boilerplate:** [GitLab DZigual - Boilerplate 2024](https://gitlab.dzigual.com.br/mint/boilerplate-2024)

### Gerenciamento de Dependências e Autoloading
Diferente de plugins WordPress "tradicionais" que utilizam múltiplos `include` ou `require`, este projeto utiliza o **Composer** para autoloading (PSR-4).

* **Namespace Base:** `Src\` mapeia para a pasta `./src/`.
* **Funcionamento:** O arquivo principal do plugin (`discord-notifications.php`) carrega o autoloader (`require_once __DIR__ . '/vendor/autoload.php'`). Isso permite que as classes sejam instanciadas automaticamente quando chamadas, mantendo o código limpo e desacoplado.

⚠️ **IMPORTANTE:**
Toda vez que você adicionar uma nova classe, alterar o nome de um arquivo ou modificar a estrutura de pastas dentro de `src/`, é obrigatório rodar o comando abaixo para atualizar o mapa de classes do Composer:

```bash
composer dump-autoload
````


## ⚙️ Configuração (wp-config.php)

Para maior segurança e controle em ambientes de produção (especialmente quando gerenciado via infraestrutura como código), o plugin aceita constantes definidas no arquivo `wp-config.php` do WordPress.

O uso dessas constantes tem prioridade sobre as configurações salvas no banco de dados.

### Variáveis Disponíveis

| Constante | Tipo | Descrição e Motivo de Uso |
| :--- | :--- | :--- |
| `DISCORD_WEBHOOK_URL` | `string` | **Define a URL do Webhook do Discord.**<br>• **Por que usar:** Permite "hardcodar" o destino das notificações, impedindo que administradores alterem a URL via painel. Ideal para deploys automatizados onde a URL é injetada via variáveis de ambiente do servidor. |
| `DISCORD_NOTIFICATIONS_HIDE_SETTINGS` | `bool` | **Oculta o menu de configurações.**<br>• **Por que usar:** Se definido como `true`, a página de configurações do plugin desaparece do menu do WordPress. Útil para entregar o site ao cliente final sem permitir que ele desative alertas ou veja configurações sensíveis de infraestrutura. |

### Exemplo de Uso

Adicione ao seu `wp-config.php`:

```php
// Define o Webhook fixo (o campo no admin será desabilitado/ignorado)
define('DISCORD_WEBHOOK_URL', '[https://discord.com/api/webhooks/123456/abcdef](https://discord.com/api/webhooks/123456/abcdef)...');

// Oculta o menu "Discord Notifications" do painel admin
define('DISCORD_NOTIFICATIONS_HIDE_SETTINGS', true);
```

-----

## 🚀 Funcionalidades Monitoradas

O plugin utiliza a classe `Src\Main` para orquestrar os hooks e `Src\Notifier` para o envio.

Os seguintes eventos geram notificações (configuráveis via Admin, a menos que oculto):

  * **Plugins:** Atualização, Ativação, Desativação e Exclusão.
  * **Core:** Atualização do núcleo do WordPress.
  * **Segurança:** Login de usuários com perfil de Administrador.
  * **Gestão de Usuários:** Criação e Exclusão de administradores.

## 💻 Desenvolvimento Local

1.  Clone o plugin dz-discord-notifications dentro de `wp-content/plugins/`.
2.  Instale as dependências (mesmo que apenas o autoloader):
    ```bash
    composer install
    ```
3.  Ative o plugin no painel do WordPress.

-----

**Autor:** Dzigual
**Versão:** 1.2 (Refatorado Multi-arquivos)
