<?php

namespace Csanquer\Bundle\MarkdownBundle\Highlighter;

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

    /**
     * @var array
     */
    protected $availableStyles;

    public function __construct($pygmentize = '/usr/bin/pygmentize')
    {
        $this->pygmentize = $pygmentize;
    }

    public function getSupportedLanguages()
    {
        if (empty($this->supportedLanguages)) {
            $languages = $this->runCommand($this->pygmentize.' -L lexer | grep "^\*" | sed  \'s/^\*\s*\(.\+\):$/\1/\' | sed \'s/\s*,\s*/\n/g\'');
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

        $colorizedText = $this->runCommand('echo \''.$text.'\' | '.$this->pygmentize.' -l '.$language.' -f html '.$argstring);

        return preg_replace(
            '#<div class="highlight"><pre([^<>]*)>(.*)</pre></div>#s',
            '<div><pre$1><code class="highlight pygments '.$language.'">$2</code></pre></div>',
            $colorizedText
        );
    }

    public function getStylesheets(array $options = array())
    {
        $style = empty($options['style']) ? null : $options['style'];

        if (!in_array($style, $this->getAvailableStyles())) {
            $style = 'colorful';
        }

        $formatter = 'html';
        $styles = $this->runCommand($this->pygmentize.' -f '.$formatter.' -S '.$style);

        return $styles;
    }

    /**
     *
     * @return array
     */
    public function getAvailableStyles()
    {
        if (empty($this->availableStyles)) {
            $styles = $this->runCommand($this->pygmentize.' -L styles | grep "^\*" | sed  \'s/^\*\s*\(.\+\):$/\1/\'');
            $this->availableStyles = explode("\n", trim($styles));
            sort($this->availableStyles);
        }

        return $this->availableStyles;
    }

    protected function runCommand($cmd)
    {
        $result = shell_exec($cmd);

        return $result;
    }
}
