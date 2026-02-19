# WebP Easy WordPress

Plugin WordPress para escanear referências de imagens (Media Library, post content, ACF e post meta), converter JPG/PNG para WebP e atualizar referências em lotes com segurança.

## Estrutura de arquivos

```text
lever-webp-migrator/
├── lever-webp-migrator.php
├── README.md
├── assets/
│   └── admin.js
└── includes/
    ├── AdminPage.php
    ├── Autoloader.php
    ├── CliCommand.php
    ├── Converter.php
    ├── Logger.php
    ├── Plugin.php
    ├── ReferenceUpdater.php
    ├── Scanner.php
    └── Utils.php
```

## Instalação

1. Copie a pasta `lever-webp-migrator` para `wp-content/plugins/`.
2. Ative o plugin no painel do WordPress.
3. Vá em **Ferramentas > WebP Easy WordPress**.
4. Clique em **Scan** para gerar inventário e fila.
5. (Opcional) habilite **Dry-run**.
6. Clique em **Convert** para iniciar o processamento em lotes.

## WP-CLI

```bash
wp lever-webp convert --batch=25 --quality=85
wp lever-webp convert --dry-run
wp lever-webp convert --network
```

## Como funciona a lógica ACF

1. O scanner detecta ACF ativo via `acf_get_field_groups` / `get_field_objects`.
2. Para cada post, lê os objetos de campo ACF e percorre recursivamente:
   - `image` e `gallery`
   - `repeater`
   - `flexible_content`
   - sub_fields aninhados (inclusive níveis profundos)
3. Durante a coleta, identifica IDs de attachment e URLs de imagem suportadas.
4. Na fase de atualização, todo `postmeta` passa por `maybe_unserialize` e substituição recursiva segura.
5. Ao persistir, usa `maybe_serialize` para manter integridade de arrays/estruturas serializadas, incluindo metadados ACF.

## Segurança e compatibilidade

- Verificação de nonce em AJAX.
- Verificação de capability `manage_options`.
- Conversão com Imagick + fallback GD.
- Sem sobrescrever originais (gera `.webp` ao lado dos arquivos existentes).
- Atualiza metadados de attachment com bloco `webp` sem remover miniaturas legadas.
- Suporte a multisite (ativação network e CLI com `--network`).
- Logging em `wp-content/uploads/lever-webp-migrator-logs/migration.log`.
