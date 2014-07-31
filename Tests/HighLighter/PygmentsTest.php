<?php

namespace Csanquer\Bundle\MarkdownBundle\Tests\HighLighter;

use Csanquer\Bundle\MarkdownBundle\Highlighter\Pygments;

class PygmentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Geshi
     */
    protected $highlighter;

    protected function setUp()
    {
        $this->highlighter = new Pygments();
    }

    public function testColorize()
    {
        $code = <<<PHP
<?php
phpinfo();

PHP;

        $html = <<<HTML
<table class="highlighttable"><tr><td class="linenos"><div class="linenodiv"><pre>1
2</pre></div></td><td class="code"><div><pre><code class="highlight pygments php"><span class="cp">&lt;?php</span>
<span class="nb">phpinfo</span><span class="p">();</span>
</code></pre></div>
</td></tr></table>
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
            'html',
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
            'jinja',
            'vim',
            'xml',
            'yaml',
        );

        $supported = $this->highlighter->getSupportedLanguages();

        foreach ($expected as $lang) {
            $this->assertContains($lang, $supported);
        }
    }

    public function testGetAvailableStyles()
    {
        $expected = array(
            'autumn',
            'borland',
            'bw',
            'colorful',
            'default',
            'emacs',
            'friendly',
            'fruity',
            'manni',
            'monokai',
            'murphy',
            'native',
            'pastie',
            'perldoc',
            'tango',
            'trac',
            'vs',
        );

        $styles = $this->highlighter->getAvailableStyles();

        foreach ($expected as $style) {
            $this->assertContains($style, $styles);
        }
    }

    public function testGetStylesheets()
    {
        $this->assertNotEmpty($this->highlighter->getStylesheets());
    }
}
