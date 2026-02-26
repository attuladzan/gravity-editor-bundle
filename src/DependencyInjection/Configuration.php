<?php

declare(strict_types=1);

namespace GravityUI\MarkdownEditorBundle\DependencyInjection;

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
        $treeBuilder = new TreeBuilder('gravity_ui_markdown_editor');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->enumNode('integration')
                    ->values(['npm', 'cdn'])
                    ->defaultValue('cdn')
                    ->info('Asset delivery: npm (via AssetMapper/Webpack) or cdn (esm.sh, no package manager)')
                ->end()
                ->scalarNode('package_version')
                    ->defaultValue('15.34.3')
                    ->info('@gravity-ui/markdown-editor package version for CDN')
                ->end()
                ->scalarNode('cdn_base_url')
                    ->defaultValue('https://esm.sh')
                    ->info('CDN base for ESM imports (esm.sh)')
                ->end()
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
