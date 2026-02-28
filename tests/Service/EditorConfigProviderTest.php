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

    public function testGetEnabledPlugins(): void
    {
        $provider = new EditorConfigProvider([], [
            'mermaid' => true,
            'latex' => false,
            'html' => true,
        ]);

        $plugins = $provider->getEnabledPlugins();
        $this->assertSame(['mermaid', 'html'], $plugins);
    }

    public function testGetEnabledPluginsEmpty(): void
    {
        $provider = new EditorConfigProvider([]);
        $this->assertSame([], $provider->getEnabledPlugins());
    }
}
