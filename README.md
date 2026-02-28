   # Gravity UI Markdown Editor Bundle

Symfony 8.1 bundle for [@gravity-ui/markdown-editor](https://github.com/gravity-ui/markdown-editor) integration.

## Features

- **Forms**: `MarkdownEditorType` form type
- **Twig**: `gravity_markdown_editor()` function (works without React build — CDN mode loads React + editor from esm.sh)
- **EasyAdmin 5**: `MarkdownEditorField` (when easycorp/easyadmin-bundle is installed)
- **No npm required**: CDN mode uses esm.sh (ES modules)
- **YAML config**: Editor options via bundle configuration

## Installation

```bash
composer require attuladzan/gravity-editor-bundle
```

Register in `config/bundles.php`:

```php
return [
    // ...
    Attuladzan\MarkdownEditorBundle\AttuladzanMarkdownEditorBundle::class => ['all' => true],
];
```

## Configuration

```yaml
# config/packages/attuladzan_markdown_editor.yaml
attuladzan_markdown_editor:
    integration: cdn   # cdn | npm
    package_version: '15.34.3'
    cdn_base_url: 'https://esm.sh'
    editor:
        allow_html: false
        sticky_toolbar: true
        autofocus: false
        lang: en
```

## Usage

### Form Type

```php
use Attuladzan\MarkdownEditorBundle\Form\MarkdownEditorType;

$builder->add('content', MarkdownEditorType::class, [
    'editor_options' => ['allow_html' => true],
]);
```

### Twig (direct)

```twig
{{ gravity_markdown_editor({ name: 'content', value: content }) }}
```

### EasyAdmin 5

```php
use Attuladzan\MarkdownEditorBundle\EasyAdmin\Field\MarkdownEditorField;

yield MarkdownEditorField::new('content');
```

Install EasyAdmin and optionally twig/extra-bundle for markdown preview:

```bash
composer require easycorp/easyadmin-bundle
composer require twig/extra-bundle   # for markdown_to_html in index/detail
```

## Integration Modes

| Mode | Description |
|------|-------------|
| `cdn` | No npm. Editor loaded from esm.sh (React + @gravity-ui/markdown-editor as ESM). |
| `npm` | Install `@gravity-ui/markdown-editor` via npm and register `window.GravityUIMarkdownEditorInit` to hydrate. |

## Releasing

1. Update version in `composer.json` (optional, tag takes precedence).
2. Create and push a tag:
   ```bash
   git tag v1.0.0
   git push origin v1.0.0
   ```
3. GitHub Actions will:
   - Run tests
   - Create a GitHub Release with auto-generated notes
   - Trigger Packagist update (if `PACKAGIST_USERNAME` and `PACKAGIST_TOKEN` secrets are set)

To enable automatic Packagist updates, add repository secrets in GitHub:
- `PACKAGIST_USERNAME` — your Packagist username
- `PACKAGIST_TOKEN` — API token from [Packagist profile](https://packagist.org/profile/)

## License

MIT
