# Gravity UI Markdown Editor Bundle

Symfony 8.1 bundle for [@gravity-ui/markdown-editor](https://github.com/gravity-ui/markdown-editor) integration.

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

With [Symfony Flex](https://symfony.com/doc/current/setup/flex.html), the bundle is auto-registered and `assets:install` runs after install.

Without Flex, register in `config/bundles.php`:

```php
return [
    // ...
    Attuladzan\MarkdownEditorBundle\AttuladzanMarkdownEditorBundle::class => ['all' => true],
];
```

### Install assets

Pre-built assets are included. Install them into `public/`:

```bash
php bin/console attuladzan:markdown-editor:install-assets
```

Options:

- `--symlink` — create symlinks instead of copying (useful in development)
- `--build` — run `npm run build` before installing (if you modified bundle assets)

### Rebuild assets (developers)

If you changed the bundle's JS/CSS:

```bash
cd vendor/attuladzan/gravity-editor-bundle
npm install
npm run build
php bin/console attuladzan:markdown-editor:install-assets
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

**Important:** Add the bundle's form theme so the visual editor renders on new/edit pages. In your `DashboardController` or each `CrudController`:

```php
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

public function configureCrud(Crud $crud): Crud
{
    return $crud
        // ...
        ->addFormTheme('@AttuladzanMarkdownEditor/Form/attuladzan_markdown_editor_widget.html.twig');
}
```

Install EasyAdmin and optionally twig/extra-bundle for markdown preview:

```bash
composer require easycorp/easyadmin-bundle
composer require twig/extra-bundle   # for markdown_to_html in index/detail
```

## Flex recipe

To enable auto-install of assets via `composer require`, submit a recipe to [symfony/recipes-contrib](https://github.com/symfony/recipes-contrib). The recipe structure is in `Recipe/1.0/`.

## Releasing

1. Update version in `composer.json` (optional, tag takes precedence).
2. Build assets: `npm run build`
3. Create and push a tag:
   ```bash
   git tag v1.0.0
   git push origin v1.0.0
   ```
4. GitHub Actions will:
   - Run tests
   - Create a GitHub Release with auto-generated notes
   - Trigger Packagist update (if `PACKAGIST_USERNAME` and `PACKAGIST_TOKEN` secrets are set)

To enable automatic Packagist updates, add repository secrets in GitHub:
- `PACKAGIST_USERNAME` — your Packagist username
- `PACKAGIST_TOKEN` — API token from [Packagist profile](https://packagist.org/profile/)

## License

MIT
