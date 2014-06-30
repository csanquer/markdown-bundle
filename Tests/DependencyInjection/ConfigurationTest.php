<?php

namespace CSanquer\Bundle\MarkdownBundle\Tests\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use CSanquer\Bundle\MarkdownBundle\DependencyInjection\Configuration;

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
                    'parser' => array(
                        'type' => 'parsedown',
                        'use_highlighter' => true,
                        'cache' => array(
                            'id' => null,
                            'prefix' => 'markdown',
                            'ttl' => 0,
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
