<?php

declare(strict_types=1);

namespace Attuladzan\MarkdownEditorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Bundle configuration for gravity-ui/markdown-editor.
 *
 * Maps to useMarkdownEditor options (allowHTML) and MarkdownEditorView props (stickyToolbar, autofocus).
 */
final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('attuladzan_markdown_editor');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('editor')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('allow_html')
                            ->defaultFalse()
                            ->info('Allow HTML in markdown (useMarkdownEditor.allowHTML)')
                        ->end()
                        ->booleanNode('sticky_toolbar')
                            ->defaultTrue()
                            ->info('Sticky toolbar on scroll (MarkdownEditorView)')
                        ->end()
                        ->booleanNode('autofocus')
                            ->defaultFalse()
                            ->info('Auto-focus editor on mount')
                        ->end()
                        ->scalarNode('lang')
                            ->defaultValue('en')
                            ->info('Editor locale: en, ru, etc.')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
