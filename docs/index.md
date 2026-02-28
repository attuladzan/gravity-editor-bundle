# Gravity UI Markdown Editor Bundle

Symfony integration for [@gravity-ui/markdown-editor](https://github.com/gravity-ui/markdown-editor).

## Features

- **Forms**: `MarkdownEditorType` form type
- **Twig**: `gravity_markdown_editor()` function
- **EasyAdmin 5**: `MarkdownEditorField` (when easycorp/easyadmin-bundle is installed)
- **JS build**: Editor loaded from bundled assets (Vite build)
- **YAML config**: Editor options via bundle configuration

## Installation

```bash
composer require attuladzan/gravity-editor-bundle
```

Build assets and install:

```bash
cd vendor/attuladzan/gravity-editor-bundle && npm install && npm run build
php bin/console assets:install
```

## Configuration

```yaml
# config/packages/attuladzan_markdown_editor.yaml
attuladzan_markdown_editor:
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

$builder->add('content', MarkdownEditorType::class);
```

### Twig

```twig
{{ gravity_markdown_editor({ name: 'content', value: content }) }}
```

### EasyAdmin 5

```php
use Attuladzan\MarkdownEditorBundle\EasyAdmin\Field\MarkdownEditorField;

yield MarkdownEditorField::new('content');
```

Requires: `composer require easycorp/easyadmin-bundle` and optionally `twig/extra-bundle` for markdown preview in index/detail.
