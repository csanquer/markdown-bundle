<?php

namespace Csanquer\Bundle\MarkdownBundle\Tests\Parser;

use Csanquer\Bundle\MarkdownBundle\Parser\MarkdownParserFactory;

class MarkdownParserFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MarkdownParserFactory
     */
    protected $factory;

    protected function setUp()
    {
        /* *
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
        /**/

        $this->factory = new MarkdownParserFactory();
    }

    /**
     * @dataProvider providerGetHighlighter
     */
    public function testGetHighlighter($type, $class)
    {
        $this->assertInstanceof($class, $this->factory->getHighlighter($type));
    }

    public function providerGetHighlighter()
    {
        return array(
            array(
                'geshi',
                '\\Csanquer\\Bundle\\MarkdownBundle\\Highlighter\\Geshi',
            ),
            array(
                'pygments',
                '\\Csanquer\\Bundle\\MarkdownBundle\\Highlighter\\Pygments',
            ),
        );
    }

    /**
     * @dataProvider providerGetParser
     */
    public function testGetParser($type, $class)
    {
        if ($type === 'sundown' && !extension_loaded('sundown')) {
            $this->setExpectedException('RuntimeException', 'Sundown extension is not loaded.');
        }

        $this->assertInstanceof($class, $this->factory->getParser($type));
    }

    public function providerGetParser()
    {
        return array(
            array(
                'parsedown',
                '\\Csanquer\\Bundle\\MarkdownBundle\\Parser\\ParsedownParser',
            ),
            array(
                'sundown',
                '\\Csanquer\\Bundle\\MarkdownBundle\\Parser\\SundownParser',
            ),
        );
    }
}
