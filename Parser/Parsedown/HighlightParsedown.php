<?php

namespace CSanquer\Bundle\MarkdownBundle\Parser\Parsedown;

use \CSanquer\Bundle\MarkdownBundle\Highlighter\HighlighterInterface;

class HighlightParsedown extends \Parsedown
{
    /**
     * @var Highlighter
     */
    protected $highlighter;

    public function __construct(HighlighterInterface $highlighter = null)
    {
        $this->highlighter = $highlighter;
    }

    protected function completeFencedCode($Block)
    {
        if (!$this->highlighter) {
            return parent::completeFencedCode($Block);
        }

        $language = null;
        if (isset($Block['element']['text']['attributes']['class'])) {
            $language = str_ireplace('language-', '', $Block['element']['text']['attributes']['class']);
        }

        if (!empty($language)) {
            $colorized = $this->highlighter->colorize($Block['element']['text']['text'], $language);
            $Block['element']['text']['text'] = $colorized['text'];
            $Block['element']['text']['attributes']['class'] .= ' '.$colorized['class'];
        }

        return $Block;
    }
}