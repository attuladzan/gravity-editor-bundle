# Gravity UI Markdown Editor Bundle

Symfony-интеграция редактора [@gravity-ui/markdown-editor](https://github.com/gravity-ui/markdown-editor) — WYSIWYG + Markup, ProseMirror/CodeMirror, YFM.

**Разработчик:** [attuladzan](https://github.com/attuladzan/gravity-editor-bundle)

## Сообщества / Communities

| | Русский | English |
|---|---------|---------|
| **Gravity UI** | [Telegram: @gravity_ui](https://t.me/gravity_ui) (новости), [@gravity_ui_chat](https://t.me/gravity_ui_chat) (чат) | [GitHub](https://github.com/gravity-ui/markdown-editor) · [gravity-ui.com](https://gravity-ui.com/libraries/markdown-editor) |
| **Бандл** | [GitHub Issues](https://github.com/attuladzan/gravity-editor-bundle/issues) | [Packagist](https://packagist.org/packages/attuladzan/gravity-editor-bundle) |

---

## Установка

```bash
composer require attuladzan/gravity-editor-bundle
```

Без Flex — добавьте в `config/bundles.php`:

```php
Attuladzan\MarkdownEditorBundle\AttuladzanMarkdownEditorBundle::class => ['all' => true],
```

Установка ассетов:

```bash
php bin/console attuladzan:markdown-editor:install-assets
```

Опции: `--symlink` (для разработки), `--build` (пересборка перед установкой).

---

## Конфигурация

```yaml
# config/packages/attuladzan_markdown_editor.yaml
attuladzan_markdown_editor:
    editor:
        allow_html: false
        sticky_toolbar: true
        autofocus: false
        lang: en   # или ru
    plugins:
        mermaid: false   # диаграммы Mermaid
        latex: false    # формулы LaTeX
        html: false     # HTML-блоки
```

### Плагины

Плагины расширяют возможности редактора по [документации](https://github.com/gravity-ui/markdown-editor/tree/main/docs):

| Плагин | Описание | Зависимость |
|--------|----------|-------------|
| `mermaid` | Диаграммы Mermaid | @diplodoc/mermaid-extension |
| `latex` | Формулы LaTeX/Math | @diplodoc/latex-extension |
| `html` | HTML-блоки | @diplodoc/html-extension |

Плагины включены в сборку бандла. Включите нужные в конфиге (`plugins.latex: true` и т.д.).

**LaTeX:** в редакторе нажмите `/` — в меню появятся «Inline math» и «Block math».

**После изменения конфига обязательно:**
```bash
php bin/console cache:clear
```

Проверка: `php bin/console debug:config attuladzan_markdown_editor` — в выводе должно быть `plugins: { latex: true }`.

---

## Использование

### Symfony Form

```php
use Attuladzan\MarkdownEditorBundle\Form\MarkdownEditorType;

$builder->add('content', MarkdownEditorType::class, [
    'editor_options' => ['allow_html' => true],
]);
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

Добавьте form theme в CrudController:

```php
->addFormTheme('@AttuladzanMarkdownEditor/Form/attuladzan_markdown_editor_widget.html.twig');
```

Опционально для превью markdown:

```bash
composer require easycorp/easyadmin-bundle twig/extra-bundle
```

---

## Лицензия

MIT
