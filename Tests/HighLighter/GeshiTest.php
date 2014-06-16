<?php

namespace CSanquer\Bundle\MarkdownBundle\Tests\Highlighter;

use CSanquer\Bundle\MarkdownBundle\Highlighter\Geshi;

class GeshiTest extends \PHPUnit_Framework_TestCase
{
    public function testColorize()
    {
        $code = <<<PHP
<?php
phpinfo();

PHP
        ;

        $html = <<<HTML
<pre><code class="language-php">//php colorized
&lt;?php
phpinfo();
</code></pre>
HTML
        ;

        $highlighter = new Geshi();
        $this->assertEquals(
            array(
                'text' => '<span class="kw2">&lt;?php</span>
<a href="http://www.php.net/phpinfo"><span class="kw3">phpinfo</span></a><span class="br0">&#40;</span><span class="br0">&#41;</span><span class="sy0">;</span>
&nbsp;',
                'class' => 'php geshi',
            ), 
            $highlighter->colorize($code, 'php')
        );
    }
}
