<?php

declare(strict_types=1);

namespace Attuladzan\MarkdownEditorBundle\Twig;

use Attuladzan\MarkdownEditorBundle\Service\EditorConfigProvider;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Twig extension for gravity-ui markdown editor.
 *
 * Renders editor via Twig template. Supports CDN (no npm) and npm integration.
 */
final class MarkdownEditorExtension extends AbstractExtension
{
    public function __construct(
        private readonly EditorConfigProvider $configProvider,
        private readonly Environment $twig,
    ) {
    }

    /**
     * @return list<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('gravity_markdown_editor', [$this, 'renderEditor'], [
                'is_safe' => ['html'],
                'needs_context' => true,
            ]),
            new TwigFunction('gravity_markdown_editor_config', [$this, 'getEditorConfig'], []),
        ];
    }

    /**
     * Render editor markup.
     *
     * @param array<string, mixed> $context Twig context
     * @param array<string, mixed> $options Override options (id, name, value, editor_options, view_options)
     */
    public function renderEditor(array $context, array $options = []): string
    {
        $id = $options['id'] ?? ('gravity-md-' . uniqid('', true));
        $name = $options['name'] ?? 'content';
        $value = $options['value'] ?? '';

        $editorOptions = array_merge(
            $this->configProvider->getEditorOptions(),
            $options['editor_options'] ?? [],
        );
        $viewOptions = array_merge(
            $this->configProvider->getViewOptions(),
            $options['view_options'] ?? [],
        );

        return $this->twig->render('@AttuladzanMarkdownEditor/editor.html.twig', [
            'id' => $id,
            'name' => $name,
            'value' => $value,
            'editor_options' => $editorOptions,
            'view_options' => $viewOptions,
            'lang' => $this->configProvider->getLang(),
            'integration' => $this->configProvider->getIntegration(),
            'cdn_urls' => $this->getCdnUrls(),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function getEditorConfig(): array
    {
        return [
            'integration' => $this->configProvider->getIntegration(),
            'editor' => $this->configProvider->getEditorOptions(),
            'view' => $this->configProvider->getViewOptions(),
            'lang' => $this->configProvider->getLang(),
        ];
    }

    /**
     * @return array<string, string>
     */
    private function getCdnUrls(): array
    {
        if ($this->configProvider->getIntegration() !== 'cdn') {
            return [];
        }

        $version = $this->configProvider->getPackageVersion();

        return [
            'esm' => sprintf('https://esm.sh/@gravity-ui/markdown-editor@%s', $version),
            'react_esm' => 'https://esm.sh/react@18',
            'react_dom_esm' => 'https://esm.sh/react-dom@18/client',
        ];
    }
}
