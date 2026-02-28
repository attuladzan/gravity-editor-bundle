<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Attuladzan\MarkdownEditorBundle\Command\InstallAssetsCommand;
use Attuladzan\MarkdownEditorBundle\Form\MarkdownEditorType;
use Attuladzan\MarkdownEditorBundle\Service\EditorConfigProvider;
use Attuladzan\MarkdownEditorBundle\Twig\MarkdownEditorExtension;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(InstallAssetsCommand::class)
            ->args([service('kernel')])
            ->tag('console.command')

        ->set('attuladzan_markdown_editor.form.type', MarkdownEditorType::class)
            ->args([service('attuladzan_markdown_editor.config_provider')])
            ->tag('form.type')

        ->set('attuladzan_markdown_editor.config_provider', EditorConfigProvider::class)
            ->args([
                param('attuladzan_markdown_editor.editor'),
            ])
            ->alias(EditorConfigProvider::class, 'attuladzan_markdown_editor.config_provider')

        ->set('attuladzan_markdown_editor.twig_extension', MarkdownEditorExtension::class)
            ->args([
                service('attuladzan_markdown_editor.config_provider'),
                service('twig'),
            ])
            ->tag('twig.extension')
    ;
};
