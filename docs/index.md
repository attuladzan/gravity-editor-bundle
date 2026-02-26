# Gravity UI Markdown Editor Bundle

Symfony integration for [@gravity-ui/markdown-editor](https://github.com/gravity-ui/markdown-editor).

## Features

- **Forms**: `MarkdownEditorType` form type
- **Twig**: `gravity_markdown_editor()` function
- **EasyAdmin 5**: `MarkdownEditorField` (when easycorp/easyadmin-bundle is installed)
- **No npm required**: CDN mode uses esm.sh (ES modules from CDN)
- **YAML config**: Editor options via bundle configuration

## Installation

```bash
composer require teggoin/gravity-editor-bundle
```

## Configuration

```yaml
# config/packages/teggoin_markdown_editor.yaml
teggoin_markdown_editor:
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
use Teggoin\MarkdownEditorBundle\Form\MarkdownEditorType;

$builder->add('content', MarkdownEditorType::class);
```

### Twig

```twig
{{ gravity_markdown_editor({ name: 'content', value: content }) }}
```

### EasyAdmin 5

```php
use Teggoin\MarkdownEditorBundle\EasyAdmin\Field\MarkdownEditorField;

yield MarkdownEditorField::new('content');
```

Requires: `composer require easycorp/easyadmin-bundle` and optionally `twig/extra-bundle` for markdown preview in index/detail.

## Integration Modes

- **cdn**: No npm. Editor loaded from esm.sh (React + @gravity-ui/markdown-editor as ESM).
- **npm**: Install `@gravity-ui/markdown-editor` via npm and register `GravityUIMarkdownEditorInit` to hydrate.
