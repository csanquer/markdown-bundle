<?php 

namespace CSanquer\Bundle\MarkdownBundle\Highlighter;

class Geshi implements HighlighterInterface
{
    /**
     * @var \GeSHi
     */
    protected $colorizer;

    public function __construct()
    {
        $this->colorizer = new \GeSHi();
        $this->colorizer->enable_classes();
        $this->colorizer->set_overall_class('geshi');
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
}