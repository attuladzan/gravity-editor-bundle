<?php

declare(strict_types=1);

namespace Teggoin\MarkdownEditorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

final class TeggoinMarkdownEditorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('teggoin_markdown_editor.integration', $config['integration']);
        $container->setParameter('teggoin_markdown_editor.package_version', $config['package_version']);
        $container->setParameter('teggoin_markdown_editor.cdn_base_url', $config['cdn_base_url']);
        $container->setParameter('teggoin_markdown_editor.editor', $config['editor']);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');
    }
}
