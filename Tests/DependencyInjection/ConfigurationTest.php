<?php

namespace Csanquer\Bundle\MarkdownBundle\Tests\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Csanquer\Bundle\MarkdownBundle\DependencyInjection\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataForProcessedConfiguration
     */
    public function testProcessedConfiguration($configs, $expectedConfig)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $this->assertEquals($expectedConfig, $config);
    }

    public function dataForProcessedConfiguration()
    {
        return array(
            array(
                array(),
                array(
                    'preview' => array(
                        'bootstrap_icons' => 'glyph',
                        'var' => 'markdown',
                        'use_template' => false,
                        'template' => 'CsanquerMarkdownBundle:Preview:layout.html.twig',
                    ),
                    'parser' => array(
                        'type' => 'parsedown',
                        'use_highlighter' => true,
                        'cache' => array(
                            'id' => null,
                            'prefix' => 'markdown',
                            'ttl' => 0,
                        ),
                        'sundown' => array(
                            'extensions' => array(
                                'no_intra_emphasis' => false,
                                'tables' => true,
                                'fenced_code_blocks' => true,
                                'autolink' => true,
                                'strikethrough' => true,
                                'lax_html_blocks' => false,
                                'space_after_headers' => true,
                                'superscript' => false,
                            ),
                            'flags' => array(
                                'filter_html' => false,
                                'no_images' => false,
                                'no_links' => false,
                                'no_styles' => false,
                                'safe_links_only' => false,
                                'with_toc_data' => false,
                                'hard_wrap' => true,
                                'xhtml' => true,
                            ),
                        ),
                    ),
                    'highlighter' => array(
                        'type' => 'geshi',
                        'pygmentize_bin' => '/usr/bin/pygmentize',
                    ),
                )
            ),
        );
    }
}
