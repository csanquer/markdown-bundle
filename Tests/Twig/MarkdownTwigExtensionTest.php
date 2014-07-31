<?php

namespace Csanquer\Bundle\MarkdownBundle\Tests\Twig;

use Csanquer\Bundle\MarkdownBundle\Twig\Extension\MarkdownTwigExtension;
use Csanquer\Bundle\MarkdownBundle\Helper\MarkdownHelper;
use Csanquer\Bundle\MarkdownBundle\Parser\Parsedown\HighlightParsedown;
use Csanquer\Bundle\MarkdownBundle\Parser\ParsedownParser;

class MarkdownTwigExtensionTest extends \Twig_Test_IntegrationTestCase
{
    public function getExtensions()
    {
        $highlighter = $this->getMock('\\Csanquer\\Bundle\\MarkdownBundle\\Highlighter\\HighlighterInterface');
        $highlighter->expects($this->any())
            ->method('colorize')
            ->will($this->returnCallback(function ($text, $language) {
                        return "<pre><code class=\"language-php php test-highlighter\">//$language colorized\n".htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8').'</code></pre>';
                    }));

        $helper = new MarkdownHelper(new ParsedownParser(new HighlightParsedown($highlighter)));

        return array(
            new MarkdownTwigExtension($helper),
        );
    }

    public function getFixturesDir()
    {
        return dirname(__FILE__).'/Fixtures/';
    }
}
