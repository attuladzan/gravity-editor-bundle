<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use GravityUI\MarkdownEditorBundle\Form\MarkdownEditorType;
use GravityUI\MarkdownEditorBundle\Service\EditorConfigProvider;
use GravityUI\MarkdownEditorBundle\Twig\MarkdownEditorExtension;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set('gravity_ui_markdown_editor.form.type', MarkdownEditorType::class)
            ->args([service('gravity_ui_markdown_editor.config_provider')])
            ->tag('form.type')

        ->set('gravity_ui_markdown_editor.config_provider', EditorConfigProvider::class)
            ->args([
                param('gravity_ui_markdown_editor.integration'),
                param('gravity_ui_markdown_editor.package_version'),
                param('gravity_ui_markdown_editor.cdn_base_url'),
                param('gravity_ui_markdown_editor.editor'),
            ])
            ->alias(EditorConfigProvider::class, 'gravity_ui_markdown_editor.config_provider')

        ->set('gravity_ui_markdown_editor.twig_extension', MarkdownEditorExtension::class)
            ->args([
                service('gravity_ui_markdown_editor.config_provider'),
                service('twig'),
            ])
            ->tag('twig.extension')
    ;
};
