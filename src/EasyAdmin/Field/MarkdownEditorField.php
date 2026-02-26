<?php

declare(strict_types=1);

namespace GravityUI\MarkdownEditorBundle\EasyAdmin\Field;

use EasyCorp\Bundle\EasyAdminBundle\Contract\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use GravityUI\MarkdownEditorBundle\Form\MarkdownEditorType;

/**
 * EasyAdmin 5 Field for gravity-ui markdown editor.
 *
 * Use in your CrudController:
 *
 *   yield MarkdownEditorField::new('content');
 */
final class MarkdownEditorField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label ?? $propertyName)
            ->setFormType(MarkdownEditorType::class)
            ->setTemplatePath('@GravityUIMarkdownEditor/EasyAdmin/field_markdown.html.twig');
    }
}
