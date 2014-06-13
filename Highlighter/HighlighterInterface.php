<?php 

namespace CSanquer\Bundle\ParsedownBundle\Highlighter;

interface HighlighterInterface
{
    /**
     * @param string $text
     * @param string $language
     * 
     * @return string
     */
    public function colorize($text, $language);
}