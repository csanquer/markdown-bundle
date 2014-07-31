<?php

namespace Csanquer\Bundle\MarkdownBundle\Tests\Parser;

use Csanquer\Bundle\MarkdownBundle\Highlighter\HighlighterInterface;
use Csanquer\Bundle\MarkdownBundle\Parser\Parsedown\HighlightParsedown;
use Csanquer\Bundle\MarkdownBundle\Parser\ParsedownParser;
use Csanquer\Bundle\MarkdownBundle\Parser\CachedMarkdownParser;
use Doctrine\Common\Cache\ArrayCache;

class CachedMarkdownParserTest extends \PHPUnit_Framework_TestCase
{
    protected $parser;

    protected $cache;

    protected function setUp()
    {
        $highlighter = $this->getMock('\\Csanquer\\Bundle\\MarkdownBundle\\Highlighter\\HighlighterInterface');
        $highlighter->expects($this->any())
            ->method('colorize')
            ->will($this->returnCallback(function ($text, $language) {
                return "<pre><code class=\"language-php php test-highlighter\">//$language colorized\n".htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8').'</code></pre>';
            }));

        $this->cache = new ArrayCache();
        $this->parser = new CachedMarkdownParser(new ParsedownParser(new HighlightParsedown($highlighter)), $this->cache, 0, 'test_markdown');
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

        $id = 'test_markdown.'.md5($markdown);
        $this->assertFalse($this->cache->contains($id));
        $this->assertEquals($html, $this->parser->transform($markdown));
        $this->assertTrue($this->cache->contains($id));
        $this->assertEquals($this->cache->fetch($id), $this->parser->transform($markdown));
    }
}
