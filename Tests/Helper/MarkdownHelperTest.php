<?php

namespace CSanquer\Bundle\MarkdownBundle\Tests\Helper;

use CSanquer\Bundle\MarkdownBundle\Helper\MarkdownHelper;
use CSanquer\Bundle\MarkdownBundle\Parser\Parsedown\HighlightParsedown;
use CSanquer\Bundle\MarkdownBundle\Parser\ParsedownParser;

class MarkdownHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MarkdownHelper
     */
    protected $helper;

    protected function setUp()
    {
        $highlighter = $this->getMock('\\CSanquer\\Bundle\\MarkdownBundle\\Highlighter\\HighlighterInterface');
        $highlighter->expects($this->any())
            ->method('colorize')
            ->will($this->returnCallback(function ($text, $language) {
                        return "<pre><code class=\"language-php php test-highlighter\">//$language colorized\n".htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8').'</code></pre>';
                    }));

        $this->helper = new MarkdownHelper(new ParsedownParser(new HighlightParsedown($highlighter)));
    }

    public function testGetName()
    {
        $this->assertEquals('markdown', $this->helper->getName());
    }

    public function testGetSetCharset()
    {
        $this->assertEquals('UTF-8', $this->helper->getCharset());
        $this->helper->setCharset('ISO-8859-15');
        $this->assertEquals('ISO-8859-15', $this->helper->getCharset());
    }

    public function testTransform()
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

        $this->assertEquals($html, $this->helper->transform($markdown));
    }
}
