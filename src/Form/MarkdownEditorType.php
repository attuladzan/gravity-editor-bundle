<?php

declare(strict_types=1);

namespace Attuladzan\MarkdownEditorBundle\Form;

use Attuladzan\MarkdownEditorBundle\Service\EditorConfigProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form type for gravity-ui markdown editor.
 *
 * Renders a textarea with data attributes for Twig/JS to mount the editor.
 */
final class MarkdownEditorType extends AbstractType
{
    public function __construct(
        private readonly EditorConfigProvider $configProvider,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // No additional fields needed
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['attr'] = array_merge($view->vars['attr'] ?? [], [
            'data-gravity-markdown-editor' => 'true',
        ]);
        $view->vars['editor_options'] = array_merge(
            $this->configProvider->getEditorOptions(),
            $options['editor_options'] ?? [],
        );
        $view->vars['view_options'] = array_merge(
            $this->configProvider->getViewOptions(),
            $options['view_options'] ?? [],
        );
        $view->vars['integration'] = $this->configProvider->getIntegration();
        $view->vars['lang'] = $this->configProvider->getLang();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'editor_options' => [],
            'view_options' => [],
        ]);
        $resolver->setAllowedTypes('editor_options', 'array');
        $resolver->setAllowedTypes('view_options', 'array');
    }

    public function getParent(): ?string
    {
        return TextareaType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'attuladzan_markdown_editor';
    }
}
