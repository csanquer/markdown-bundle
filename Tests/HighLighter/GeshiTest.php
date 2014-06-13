<?php

namespace CSanquer\Bundle\ParsedownBundle\Tests\Highlighter;

use CSanquer\Bundle\ParsedownBundle\Highlighter\Geshi;

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
        $this->assertEquals($html, $highlighter->colorize($code, 'php'));
    }
}
