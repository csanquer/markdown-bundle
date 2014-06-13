<?php 

namespace CSanquer\Bundle\ParsedownBundle\Highlighter;

class Pygments implements HighlighterInterface
{
    public function colorize($text, $language)
    {
        return $text;
    }
}