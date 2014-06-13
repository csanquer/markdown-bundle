<?php

namespace CSanquer\Bundle\ParsedownBundle\Parser;

interface MarkdownParserInterface
{
    /**
     * @param string $text markdown text to transform to HTML
     * @return string result in HTML
     */
    public function transform($text);
}