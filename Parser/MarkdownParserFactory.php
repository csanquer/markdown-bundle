<?php

namespace CSanquer\Bundle\MarkdownBundle\Parser;

use \Doctrine\Common\Cache\Cache;
use CSanquer\Bundle\MarkdownBundle\Highlighter\HighlighterInterface;
use CSanquer\Bundle\MarkdownBundle\Highlighter\Geshi;
use CSanquer\Bundle\MarkdownBundle\Highlighter\Pygments;
use CSanquer\Bundle\MarkdownBundle\Parser\MarkdownParserInterface;
use CSanquer\Bundle\MarkdownBundle\Parser\ParsedownParser;
use CSanquer\Bundle\MarkdownBundle\Parser\Parsedown\HighlightParsedown;
use CSanquer\Bundle\MarkdownBundle\Parser\CachedMarkdownParser;

class MarkdownParserFactory
{
	public function getParser($type, $useHighlighter = true, $highlighter = null, $cache = null, $cacheTtl = 0, $cachePrefix = 'markdown')
	{
		switch ($type) {
//			case 'sundown':
			case 'parsedown':
			default:
				if ($useHighlighter && $highlighter instanceof HighlighterInterface) {
					$parsedown = new HighlightParsedown($highlighter);
				} else {
					$parsedown = new \Parsedown();
				}

				$parser = new ParsedownParser($parsedown);
				break;
		}

		if ($cache instanceof Cache) {
			$parser = new CachedMarkdownParser($parser, $cache, $cacheTtl, $cachePrefix);
		}

		return $parser;
	}

	/**
	 * get Highlighter service
	 *
	 * @param  string $type
	 * @param  string $pygmentizeBin
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