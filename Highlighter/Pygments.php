<?php

namespace CSanquer\Bundle\MarkdownBundle\Highlighter;

class Pygments implements HighlighterInterface
{
    /**
     * @var string pygmentize binary path
     */
    protected $pygmentize;

    /**
     * @var array
     */
    protected $supportedLanguages;

    public function __construct($pygmentize = '/usr/bin/pygmentize')
    {
        $this->pygmentize = $pygmentize;
    }

    public function getSupportedLanguages()
    {
        if (empty($this->supportedLanguages)) {
            $cmd = $this->pygmentize.' -L lexer | grep "^\*" | sed  \'s/^\*\s*\(.\+\):$/\1/\' | sed \'s/\s*,\s*/\n/g\'';
            $languages = shell_exec($cmd);
            $this->supportedLanguages = explode("\n", $languages);
        }

        return $this->supportedLanguages;
    }

    public function colorize($text, $language)
    {
        $options = array(
            'full' => 'false',
            'linenos' => 'table',
        );

        $argstring = '';
        foreach ($options as $argument => $value) {
            $argstring .= ' -P ' . escapeshellarg("$argument=$value");
        }

        $cmd = $this->pygmentize.' -l '.$language.' -f html '.$argstring;

        return preg_replace(
            '#<div class="highlight"><pre([^<>]*)>(.*)</pre></div>#s',
            '<div><pre$1><code class="highlight pygments '.$language.'">$2</code></pre></div>',
            shell_exec('echo \''.$text.'\' | '.$cmd)
        );
    }

    public function getCss($style = 'colorful')
    {
        $formatter = 'html';
        $cmd = $this->pygmentize.' -f '.$formatter.' -S '.$style;
        $styles = shell_exec($cmd);

        return $styles;
    }
}
