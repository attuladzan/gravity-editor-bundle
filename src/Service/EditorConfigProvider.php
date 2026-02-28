<?php

declare(strict_types=1);

namespace Attuladzan\MarkdownEditorBundle\Service;

/**
 * Provides editor configuration from bundle config.
 *
 * Values are computed at compile time (parameters) and served without runtime processing.
 */
final class EditorConfigProvider
{
    /**
     * @param array<string, mixed> $editorConfig
     * @param array<string, mixed> $pluginsConfig
     */
    public function __construct(
        private readonly array $editorConfig,
        private readonly array $pluginsConfig = [],
    ) {
    }

    /**
     * Editor options for useMarkdownEditor (camelCase for JS).
     *
     * @return array<string, mixed>
     */
    public function getEditorOptions(): array
    {
        $allowHtml = $this->editorConfig['allow_html'] ?? false;

        return [
            'md' => [
                'html' => $allowHtml,
            ],
        ];
    }

    /**
     * View options for MarkdownEditorView (camelCase for JS).
     *
     * @return array<string, mixed>
     */
    public function getViewOptions(): array
    {
        return [
            'stickyToolbar' => $this->editorConfig['sticky_toolbar'] ?? true,
            'autofocus' => $this->editorConfig['autofocus'] ?? false,
        ];
    }

    public function getLang(): string
    {
        return $this->editorConfig['lang'] ?? 'en';
    }

    /**
     * Enabled plugins list for JS (e.g. ['mermaid', 'latex', 'html']).
     *
     * @return list<string>
     */
    public function getEnabledPlugins(): array
    {
        $enabled = [];
        foreach ($this->pluginsConfig as $name => $value) {
            if ($value === true) {
                $enabled[] = $name;
            }
        }

        return $enabled;
    }
}
