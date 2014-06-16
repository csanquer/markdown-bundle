<?php

namespace CSanquer\Bundle\MarkdownBundle\Parser;

use \Doctrine\Common\Cache\Cache;

class CachedMarkdownParser implements MarkdownParserInterface
{
    /**
     * @var MarkdownParserInterface
     */
    protected $parser;

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

    public function __construct(MarkdownParserInterface $parser, Cache $cache, $cacheTtl = 0, $cachePrefix = 'markdown.')
    {
        $this->parser = $parser;
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

    /**
     * @param string $text markdown text to transform to HTML
     */
    public function transform($text)
    {
        $id = $this->cachePrefix.md5($text);
        if ($this->cache->contains($id)) {
            $parsedText = $this->cache->fetch($id);
        } else {
            $parsedText = $this->parser->transform($text);
            $this->cache->save($id, $parsedText, $this->cacheTtl);
        }

        return $parsedText;
    }
}