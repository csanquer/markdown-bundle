<?php

namespace CSanquer\Bundle\MarkdownBundle\Tests\Parser;

use Sundown\Markdown;
use CSanquer\Bundle\MarkdownBundle\Parser\SundownParser;
use CSanquer\Bundle\MarkdownBundle\Parser\Sundown\Render\ColorXHTML;

class SundownParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SundownParser
     */
    protected $parser;

    protected function setUp()
    {
        if (!extension_loaded('sundown')) {
            $this->markTestSkipped(
                'The Sundown extension is not available.'
            );
        }

        $highlighter = $this->getMock('\\CSanquer\\Bundle\\MarkdownBundle\\Highlighter\\HighlighterInterface');
        $highlighter->expects($this->any())
            ->method('colorize')
            ->will($this->returnCallback(function ($text, $language) {
                    return "<pre><code class=\"language-php php test-highlighter\">//$language colorized\n".htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8').'</code></pre>';
                }));

        $extensions = array(
            'no_intra_emphasis' => false,
            'tables' => true,
            'fenced_code_blocks' => true,
            'autolink' => true,
            'strikethrough' => true,
            'lax_html_blocks' => false,
            'space_after_headers' => true,
            'superscript' => false,
        );

        $flags = array(
            'filter_html' => false,
            'no_images' => false,
            'no_links' => false,
            'no_styles' => false,
            'safe_links_only' => false,
            'with_toc_data' => false,
            'hard_wrap' => true,
            'xhtml' => true,
        );

        $this->parser = new SundownParser(new Markdown(new ColorXHTML($highlighter, $flags), $extensions));
    }

    public function testText()
    {
        $markdown = <<<MARKDOWN
Test
====

Code example :

```php
<?php
phpinfo();
```

MARKDOWN;

        $html = <<<HTML
<h1>Test</h1>
<p>Code example :</p>
<pre><code class="language-php php test-highlighter">//php colorized
&lt;?php
phpinfo();
</code></pre>
HTML;

        $this->assertEquals($html, $this->parser->transform($markdown));
    }
}
