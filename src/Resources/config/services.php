<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Teggoin\MarkdownEditorBundle\Form\MarkdownEditorType;
use Teggoin\MarkdownEditorBundle\Service\EditorConfigProvider;
use Teggoin\MarkdownEditorBundle\Twig\MarkdownEditorExtension;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('teggoin_markdown_editor.form.type', MarkdownEditorType::class)
            ->args([service('teggoin_markdown_editor.config_provider')])
            ->tag('form.type')

        ->set('teggoin_markdown_editor.config_provider', EditorConfigProvider::class)
            ->args([
                param('teggoin_markdown_editor.integration'),
                param('teggoin_markdown_editor.package_version'),
                param('teggoin_markdown_editor.cdn_base_url'),
                param('teggoin_markdown_editor.editor'),
            ])
            ->alias(EditorConfigProvider::class, 'teggoin_markdown_editor.config_provider')

        ->set('teggoin_markdown_editor.twig_extension', MarkdownEditorExtension::class)
            ->args([
                service('teggoin_markdown_editor.config_provider'),
                service('twig'),
            ])
            ->tag('twig.extension')
    ;
};
