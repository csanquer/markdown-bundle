<?php

namespace CSanquer\Bundle\MarkdownBundle\Highlighter;

class Geshi implements HighlighterInterface
{
    /**
     * @var \GeSHi
     */
    protected $colorizer;

    /**
     * @var array
     */
    protected $supportedLanguages;

    public function __construct()
    {
        $this->colorizer = new \GeSHi();
        $this->colorizer->enable_classes();
        $this->colorizer->set_overall_class('geshi');
        $this->colorizer->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS );
    }

    public function colorize($text, $language)
    {
        $this->colorizer->set_source($text);
        $this->colorizer->set_language($language);

        return preg_replace(
            '#<pre([^<>]*)>(.*)</pre>#s',
            '<pre><code$1>$2</code></pre>',
            $this->colorizer->parse_code()
        );
    }

    public function getSupportedLanguages()
    {
        if (empty($this->supportedLanguages)) {
            $this->supportedLanguages = $this->colorizer->get_supported_languages();
            sort($this->supportedLanguages);
        }

        return $this->supportedLanguages;
    }

    public function getStylesheets(array $options = array())
    {
        $css = '';
        $this->getSupportedLanguages();

        foreach ($this->supportedLanguages as $language) {
            $this->colorizer->set_language($language);
            $css .= preg_replace('/^\/\*\*.*?\*\//s', '', $this->colorizer->get_stylesheet(false));
        }

        return $css;
    }
}
