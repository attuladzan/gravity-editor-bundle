<?php

declare(strict_types=1);

namespace Attuladzan\MarkdownEditorBundle;

use Attuladzan\MarkdownEditorBundle\DependencyInjection\AttuladzanMarkdownEditorExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

/**
 * Gravity UI Markdown Editor integration for Symfony.
 *
 * Supports forms, EasyAdmin 5, Twig integration. Uses JS build (Vite).
 */
final class AttuladzanMarkdownEditorBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return __DIR__;
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new AttuladzanMarkdownEditorExtension();
    }
}
