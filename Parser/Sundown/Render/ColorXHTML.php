<?php

namespace Csanquer\Bundle\MarkdownBundle\Parser\Sundown\Render;

use Sundown\Render\XHTML;
use Csanquer\Bundle\MarkdownBundle\Highlighter\HighlighterInterface;

class ColorXHTML extends XHTML
{
    /**
     * @var Highlighter
     */
    protected $highlighter;

    public function __construct(HighlighterInterface $highlighter = null, $renderFlags = array())
    {
        $this->highlighter = $highlighter;
        parent::__construct($renderFlags);
    }

    public function blockCode($code, $language)
    {
        if (!$this->highlighter || empty($language)) {
            return parent::blockCode($code, $language);
        }

        return $this->highlighter->colorize($code, $language);
    }
}
