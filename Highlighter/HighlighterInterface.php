<?php

namespace CSanquer\Bundle\MarkdownBundle\Highlighter;

interface HighlighterInterface
{
    /**
     * @param string $text
     * @param string $language
     *
     * @return array text => colorized code, class => CSS classes string
     */
    public function colorize($text, $language);
}
