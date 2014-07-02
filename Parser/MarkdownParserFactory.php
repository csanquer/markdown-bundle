<?php

namespace CSanquer\Bundle\MarkdownBundle\Parser;

use Doctrine\Common\Cache\Cache;
use CSanquer\Bundle\MarkdownBundle\Highlighter\HighlighterInterface;
use CSanquer\Bundle\MarkdownBundle\Highlighter\Geshi;
use CSanquer\Bundle\MarkdownBundle\Highlighter\Pygments;
use CSanquer\Bundle\MarkdownBundle\Parser\Parsedown\HighlightParsedown;
use CSanquer\Bundle\MarkdownBundle\Parser\Sundown\Render\ColorXHTML;
use Sundown\Render\XHTML;
use Sundown\Markdown;

class MarkdownParserFactory
{
    public function getParser($type, $useHighlighter = true, $highlighter = null, $cache = null, $cacheTtl = 0, $cachePrefix = 'markdown')
    {
        if ($type === 'sundown' && !extension_loaded('sundown')) {
            throw new \RuntimeException('Sundown extension is not loaded.');
        }

        switch ($type) {
            case 'sundown':
                if ($useHighlighter && $highlighter instanceof HighlighterInterface) {
                    $render = new ColorXHTML($highlighter);
                } else {
                    $render = new XHTML();
                }

                $parser = new SundownParser(new Markdown($render));
                break;

            case 'parsedown':
            default:
                if ($useHighlighter && $highlighter instanceof HighlighterInterface) {
                    $parsedown = new HighlightParsedown($highlighter);
                } else {
                    $parsedown = new \Parsedown();
                }

                $parser = new ParsedownParser($parsedown);
        }

        if ($cache instanceof Cache) {
            $parser = new CachedMarkdownParser($parser, $cache, $cacheTtl, $cachePrefix);
        }

        return $parser;
    }

    /**
     * get Highlighter service
     *
     * @param  string               $type
     * @param  string               $pygmentizeBin
     * @return HighlighterInterface
     */
    public function getHighlighter($type, $pygmentizeBin = '/usr/bin/pygmentize')
    {
        switch ($type) {
            case 'pygments':
                $highlighter = new Pygments($pygmentizeBin);
                break;

            case 'geshi':
            default:
                $highlighter = new Geshi();
                break;
        }

        return $highlighter;
    }
}
