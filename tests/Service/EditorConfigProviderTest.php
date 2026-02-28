<?php

declare(strict_types=1);

namespace Attuladzan\MarkdownEditorBundle\Tests\Service;

use Attuladzan\MarkdownEditorBundle\Service\EditorConfigProvider;
use PHPUnit\Framework\TestCase;

final class EditorConfigProviderTest extends TestCase
{
    public function testGetEditorOptions(): void
    {
        $provider = new EditorConfigProvider([
            'allow_html' => true,
        ]);

        $options = $provider->getEditorOptions();
        $this->assertTrue($options['md']['html']);
    }
}
