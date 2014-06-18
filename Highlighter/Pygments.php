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
            $this->supportedLanguages = $this->colorizer->get_supported_languages();
        }

        return $this->supportedLanguages;
    }

    public function colorize($text, $language)
    {
        return $text;
    }
}