<?php

namespace Csanquer\Bundle\MarkdownBundle\Parser\Parsedown;

use \Csanquer\Bundle\MarkdownBundle\Highlighter\HighlighterInterface;

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

            if (preg_match('#<(\w+)\s?(?:class="([^"\'<>]+)")?[^<>]*>(.*)</\w+>#s', $colorized, $matches)) {
                $elt = array(
                    'name' => $matches[1],
                    'text' => $matches[3],
                );

                if (!empty($matches[2])) {
                    $elt['attributes'] = array(
                        'class' => $matches[2],
                    );
                }

                $Block['element'] = $elt;
            }
        }

        return $Block;
    }
}
