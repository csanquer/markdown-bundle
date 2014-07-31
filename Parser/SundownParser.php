<?php

namespace Csanquer\Bundle\MarkdownBundle\Parser;

use Sundown\Markdown;

class SundownParser implements MarkdownParserInterface
{
    /**
     * @var Markdown
     */
    protected $parser;

    public function __construct(Markdown $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @param string $text markdown text to transform to HTML
     */
    public function transform($text)
    {
        return $this->parser->render($text);
    }
}
