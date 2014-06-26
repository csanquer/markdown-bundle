<?php

namespace CSanquer\Bundle\MarkdownBundle\Twig\Extension;

use CSanquer\Bundle\MarkdownBundle\Helper\MarkdownHelper;

class MarkdownTwigExtension extends \Twig_Extension
{
    /**
     * @var MarkdownHelper
     */
    protected $helper;

    public function __construct(MarkdownHelper $helper)
    {
        $this->helper = $helper;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('markdown', array($this->helper, 'transform')),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'markdown';
    }
}