<?php

namespace Csanquer\Bundle\MarkdownBundle\Helper;

use Symfony\Component\Templating\Helper\HelperInterface;
use Csanquer\Bundle\MarkdownBundle\Parser\MarkdownParserInterface;

/**
 * PHP Template View Markdown Helper
 */
class MarkdownHelper implements HelperInterface
{
    /**
     * @var MarkdownParserInterface
     */
    protected $parser;

    private $charset = 'UTF-8';

    /**
     * @param MarkdownParserInterface $parser
     */
    public function __construct(MarkdownParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * transform markdown into html
     *
     * @param  string $markdown markdown text
     * @return string
     */
    public function transform($markdown)
    {
        return $this->parser->transform($markdown);
    }

    /**
     * Sets the default charset.
     *
     * @param string $charset The charset
     *
     * @api
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * Gets the default charset.
     *
     * @return string The default charset
     *
     * @api
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     *
     * @api
     */
    public function getName()
    {
        return 'markdown';
    }
}
