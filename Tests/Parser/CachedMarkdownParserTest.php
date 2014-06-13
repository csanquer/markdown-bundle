<?php

namespace CSanquer\Bundle\ParsedownBundle\Tests\Parser;

use CSanquer\Bundle\ParsedownBundle\Highlighter\HighlighterInterface;
use CSanquer\Bundle\ParsedownBundle\Parser\HighlightParsedown;
use CSanquer\Bundle\ParsedownBundle\Parser\ParsedownParser;
use CSanquer\Bundle\ParsedownBundle\Parser\CachedMarkdownParser;
use Doctrine\Common\Cache\ArrayCache;

class CachedMarkdownParserTest extends \PHPUnit_Framework_TestCase
{
    protected $parser;
    
    protected $cache;

    protected function setUp()
    {
        $highlighter = $this->getMock('\\CSanquer\\Bundle\\ParsedownBundle\\Highlighter\\HighlighterInterface');
        $highlighter->expects($this->any())
                ->method('colorize')
                ->will($this->returnCallback(function ($text, $language) {
                    return "//$language colorized\n".$text;
                }));


        $this->cache = new ArrayCache();

        $this->parser = new CachedMarkdownParser(new ParsedownParser(new HighlightParsedown($highlighter)), $this->cache, 0, 'test_markdown.');
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
<pre><code class="language-php">//php colorized
&lt;?php
phpinfo();
</code></pre>
HTML
        ;

        $id = 'test_markdown.'.md5($markdown);
        $this->assertFalse($this->cache->contains($id));
        $this->assertEquals($html, $this->parser->transform($markdown));
        $this->assertTrue($this->cache->contains($id));
        $this->assertEquals($this->cache->fetch($id), $this->parser->transform($markdown));
    }
}