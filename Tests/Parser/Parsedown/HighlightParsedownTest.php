<?php

namespace CSanquer\Bundle\MarkdownBundle\Tests\Parser\Parsedown;

use CSanquer\Bundle\MarkdownBundle\Highlighter\HighlighterInterface;
use CSanquer\Bundle\MarkdownBundle\Parser\Parsedown\HighlightParsedown;

class HighlightParsedownTest extends \PHPUnit_Framework_TestCase
{
    protected $parser;

    protected function setUp()
    {
        $highlighter = $this->getMock('\\CSanquer\\Bundle\\MarkdownBundle\\Highlighter\\HighlighterInterface');
        $highlighter->expects($this->any())
            ->method('colorize')
            ->will($this->returnCallback(function ($text, $language) {
                return "<pre><code class=\"language-php php test-highlighter\">//$language colorized\n".htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8').'</code></pre>';
            }));

        $this->parser = new HighlightParsedown($highlighter);
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

MARKDOWN
        ;

        $html = <<<HTML
<h1>Test</h1>
<p>Code example : </p>
<pre><code class="language-php php test-highlighter">//php colorized
&lt;?php
phpinfo();
</code></pre>
HTML
        ;

        $this->assertEquals($html, $this->parser->text($markdown));
    }
}