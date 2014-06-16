<?php

namespace CSanquer\Bundle\MarkdownBundle\Parser;

class ParsedownParser implements MarkdownParserInterface
{
    /**
     * @var \Parsedown
     */
    protected $parser;

    public function __construct(\Parsedown $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param string $text markdown text to transform to HTML
     */
    public function transform($text)
    {
        return $this->parser->text($text);
    }
}