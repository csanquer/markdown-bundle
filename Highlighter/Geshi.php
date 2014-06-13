<?php 

namespace CSanquer\Bundle\ParsedownBundle\Highlighter;

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
        
        return $this->colorizer->parse_code();
    }
}