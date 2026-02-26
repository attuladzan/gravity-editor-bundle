<?php

declare(strict_types=1);

namespace Teggoin\MarkdownEditorBundle\Tests\Service;

use Teggoin\MarkdownEditorBundle\Service\EditorConfigProvider;
use PHPUnit\Framework\TestCase;

final class EditorConfigProviderTest extends TestCase
{
    public function testGetEditorOptions(): void
    {
        $provider = new EditorConfigProvider('cdn', '15.34.3', 'https://esm.sh', [
            'allow_html' => true,
        ]);

        $options = $provider->getEditorOptions();
        $this->assertTrue($options['allowHTML']);
    }

    public function testGetIntegration(): void
    {
        $provider = new EditorConfigProvider('npm', '15.34.3', 'https://esm.sh', []);
        $this->assertSame('npm', $provider->getIntegration());
    }
}
