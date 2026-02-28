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
        private readonly string $integration,
        private readonly string $packageVersion,
        private readonly string $cdnBaseUrl,
        private readonly array $editorConfig,
    ) {
    }

    public function getIntegration(): string
    {
        return $this->integration;
    }

    public function getPackageVersion(): string
    {
        return $this->packageVersion;
    }

    public function getCdnBaseUrl(): string
    {
        return $this->cdnBaseUrl;
    }

    /**
     * @return array<string, mixed>
     */
    public function getEditorConfig(): array
    {
        return $this->editorConfig;
    }

    public function getCdnUrl(string $path): string
    {
        $base = rtrim($this->cdnBaseUrl, '/');

        return sprintf('%s/@gravity-ui/markdown-editor@%s/%s', $base, $this->packageVersion, ltrim($path, '/'));
    }

    /**
     * Editor options for useMarkdownEditor (camelCase for JS).
     *
     * @return array<string, mixed>
     */
    public function getEditorOptions(): array
    {
        return [
            'allowHTML' => $this->editorConfig['allow_html'] ?? false,
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
