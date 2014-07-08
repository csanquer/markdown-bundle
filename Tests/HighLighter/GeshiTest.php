<?php

namespace CSanquer\Bundle\MarkdownBundle\Tests\HighLighter;

use CSanquer\Bundle\MarkdownBundle\Highlighter\Geshi;

class GeshiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Geshi
     */
    protected $highlighter;

    protected function setUp()
    {
        $this->highlighter = new Geshi();
    }

    public function testColorize()
    {
        $code = <<<PHP
<?php
phpinfo();

PHP;

        $html = <<<HTML
<pre><code class="php geshi"><ol><li class="li1"><div class="de1"><span class="kw2">&lt;?php</span></div></li><li class="li1"><div class="de1"><a href="http://www.php.net/phpinfo"><span class="kw3">phpinfo</span></a><span class="br0">&#40;</span><span class="br0">&#41;</span><span class="sy0">;</span></div></li><li class="li1"><div class="de1">&nbsp;</div></li></ol></code></pre>
HTML;

        $this->assertEquals($html, $this->highlighter->colorize($code, 'php'));
    }

    public function testGetSupportedLanguages()
    {
        $expected = array(
            'actionscript',
            'ada',
            'apache',
            'applescript',
            'bash',
            'c',
            'clojure',
            'cmake',
            'coffeescript',
            'cpp',
            'csharp',
            'css',
            'd',
            'delphi',
            'diff',
            'erlang',
            'fortran',
            'go',
            'haskell',
            //'html',
            'html5',
            'ini',
            'java',
            'javascript',
            'latex',
            'lua',
            'make',
            'ocaml',
            'pascal',
            'perl',
            'php',
            'python',
            'ruby',
            'scala',
            'smalltalk',
            'smarty',
            'sql',
            'tcl',
            'text',
            //'jinja',
            'twig',
            'vim',
            'xml',
            'yaml',
        );

        $supported = $this->highlighter->getSupportedLanguages();

        foreach ($expected as $lang) {
            $this->assertContains($lang, $supported);
        }
    }

    public function testGetStyles()
    {
        $this->assertNotEmpty($this->highlighter->getStyles());
    }
}
