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
     */
    public function __construct(
        private readonly array $editorConfig,
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
}
