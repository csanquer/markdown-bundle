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
        
        $parsed = $this->colorizer->parse_code();
        $result = array(
            'text' => $text,
            'class' => array($language),
        );

        if (preg_match('#<pre\s?(?:class="([^"\'<>]+)")?[^<>]*>(.*)</pre>#s', $parsed, $matches)) {
            $result['class'] = $matches[1];
            $result['text'] = $matches[2];
        }

        return $result;
    }

    public function getSupportedLanguages()
    {
        if (empty($this->supportedLanguages)) {
            $this->supportedLanguages = $this->colorizer->get_supported_languages();
            sort($this->supportedLanguages);
        }

        return $this->supportedLanguages;
    }

    public function getCss()
    {
        $css = '';
        $supportedLanguages = $this->getSupportedLanguages();

        foreach($supportedLanguages as $language) {
            $this->colorizer->set_language($language);
            $css .= preg_replace('/^\/\*\*.*?\*\//s', '', $this->colorizer->get_stylesheet(false));
        }

        return $css;
    }
}