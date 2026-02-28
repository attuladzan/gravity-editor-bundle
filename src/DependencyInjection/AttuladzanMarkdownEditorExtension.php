<?php

declare(strict_types=1);

namespace Attuladzan\MarkdownEditorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class AttuladzanMarkdownEditorExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('twig', [
            'form_themes' => ['@AttuladzanMarkdownEditor/Form/attuladzan_markdown_editor_widget.html.twig'],
        ]);
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('attuladzan_markdown_editor.editor', $config['editor']);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');
    }
}
