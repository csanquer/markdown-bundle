<?php

namespace CSanquer\Bundle\ParsedownBundle\Parser;

use \CSanquer\Bundle\ParsedownBundle\Highlighter\HighlighterInterface;

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
        if ($this->highlighter) {
            $language = null;
            if (isset($Block['element']['text']['attributes']['class'])) {
                $language = str_ireplace('language-', '', $Block['element']['text']['attributes']['class']);
            }

            if (!empty($language)) {
                $Block['element']['text']['text'] = $this->highlighter->colorize($Block['element']['text']['text'], $language);
            }
        }

        return parent::completeFencedCode($Block);
    }

    /*
    protected function completeCodeBlock($Block)
    {
        $text = $Block['element']['text']['text'];

        $text = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');

        $Block['element']['text']['text'] = $text;

        return $Block;
    }
    /**/
}