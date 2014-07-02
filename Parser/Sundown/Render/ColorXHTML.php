<?php

namespace CSanquer\Bundle\MarkdownBundle\Parser\Sundown\Render;

use Sundown\Render\XHTML;
use CSanquer\Bundle\MarkdownBundle\Highlighter\HighlighterInterface;

class ColorXHTML extends XHTML
{
    /**
     * @var Highlighter
     */
    protected $highlighter;

    public function __construct(HighlighterInterface $highlighter = null)
    {
        $this->highlighter = $highlighter;
        parent::__construct();
    }

	public function blockCode($code, $language)
	{
		if (!$this->highlighter || empty($language)) {
            return parent::blockCode($code, $language);
        }

        return $this->highlighter->colorize($code, $language);
	}
}