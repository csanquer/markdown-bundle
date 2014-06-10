<?php

namespace CSanquer\Bundle\ParsedownBundle\Parser;

use \Parsedown as BaseParsedown;
use \Doctrine\Common\Cache\Cache;
use \CSanquer\Bundle\ParsedownBundle\Highlighter\HighlighterInterface;

class Parsedown extends BaseParsedown
{
    /**
     * @var Highlighter
     */
    protected $highlighter;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var  string
     */
    protected $cachePrefix;

    /**
     * @param int 
     */
    protected $cacheTtl;

    public function __construct(HighlighterInterface $highlighter = null, Cache $cache = null, $cacheTtl = 0, $cachePrefix = 'parsedown.')
    {
        $this->highlighter = $highlighter;
        $this->cache = $cache;
        $this->setCachePrefix($cachePrefix);
        $this->setCacheTtl($cacheTtl);
    }

    public function setCachePrefix($cachePrefix)
    {
        $this->cachePrefix = (string) $cachePrefix;
    }

    public function setCacheTtl($cacheTtl)
    {
        $this->cacheTtl = (int) $cacheTtl;
    }

    public function text($text)
    {
        if (!$this->cache) {
            return parent::text($text);
        }

        $id = $this->cachePrefix.md5($text);
        if ($this->cache->contains($id)) {
            $parsedText = $this->cache->fetch($id);
        } else {
            $parsedText = parent::text($text);
            $this->cache->save($id, $parsedText, $this->cacheTtl);
        }

        return $parsedText;
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