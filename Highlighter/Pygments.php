<?php 

namespace CSanquer\Bundle\MarkdownBundle\Highlighter;

class Pygments implements HighlighterInterface
{
    /**
     * @var string pygmentize binary path
     */
    protected $pygmentize;

    public function __construct($pygmentize = '/usr/bin/pygmentize')
    {
        $this->pygmentize = $pygmentize;
    }

    public function colorize($text, $language)
    {
        return $text;
    }
}