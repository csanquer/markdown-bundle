<?php

namespace Csanquer\Bundle\MarkdownBundle\Tests\DependencyInjection;

use Csanquer\Bundle\MarkdownBundle\DependencyInjection\CsanquerMarkdownExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class CsanquerMarkdownExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testDefault()
    {
        $container = new ContainerBuilder();
        $loader = new CsanquerMarkdownExtension();
        $loader->load(array(array()), $container);

        $this->assertTrue($container->hasDefinition('csanquer_markdown.templating.helper.markdown'));
        $this->assertTrue($container->getDefinition('csanquer_markdown.templating.helper.markdown')->hasTag('templating.helper'));
        $tag = $container->getDefinition('csanquer_markdown.templating.helper.markdown')->getTag('templating.helper');
        $this->assertEquals('markdown', $tag[0]['alias']);
        $this->assertTrue($container->hasDefinition('csanquer_markdown.twig.extension.markdown.twig'));
        $this->assertTrue($container->getDefinition('csanquer_markdown.twig.extension.markdown.twig')->hasTag('twig.extension'));
        $this->assertTrue($container->hasParameter('csanquer_markdown.parser.sundown.extensions'));
        $this->assertTrue($container->hasParameter('csanquer_markdown.parser.sundown.flags'));
    }

    public function testWithCacheService()
    {
        $container = new ContainerBuilder();

        $container->setDefinition('test_markdown_cache', new Definition('Doctrine\Common\Cache\ArrayCache'));

        $loader = new CsanquerMarkdownExtension();
        $loader->load(array(array(
            'parser' => array(
                'cache' => array(
                    'id' => 'test_markdown_cache'
                ),
            ),
        )), $container);

        $parser = $container->getDefinition('csanquer_markdown.parser');
        $this->assertEquals('test_markdown_cache', $parser->getArgument(3));
    }
}
