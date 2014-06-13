<?php

namespace CSanquer\Bundle\ParsedownBundle\Tests\Parser;

use CSanquer\Bundle\ParsedownBundle\Highlighter\HighlighterInterface;
use CSanquer\Bundle\ParsedownBundle\Parser\HighlightParsedown;
use CSanquer\Bundle\ParsedownBundle\Parser\ParsedownParser;

class ParsedownParserTest extends \PHPUnit_Framework_TestCase
{
    protected $parser;

    protected function setUp()
    {
        $highlighter = $this->getMock('\\CSanquer\\Bundle\\ParsedownBundle\\Highlighter\\HighlighterInterface');
        $highlighter->expects($this->any())
                ->method('colorize')
                ->will($this->returnCallback(function ($text, $language) {
                    return "//$language colorized\n".$text;
                }));

        $this->parser = new ParsedownParser(new HighlightParsedown($highlighter));
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

        $this->assertEquals($html, $this->parser->transform($markdown));
    }
}