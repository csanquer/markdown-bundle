<?php

namespace CSanquer\Bundle\MarkdownBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class CSanquerMarkdownExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('csanquer_markdown.highlighter.type', $config['highlighter']['type']);
        $container->setParameter('csanquer_markdown.highlighter.pygmentize_bin', $config['highlighter']['pygmentize_bin']);

        $container->setParameter('csanquer_markdown.parser.type', $config['parser']['type']);
        $container->setParameter('csanquer_markdown.parser.use_highlighter', $config['parser']['use_highlighter']);
        $container->setParameter('csanquer_markdown.parser.cache.ttl', $config['parser']['cache']['ttl']);
        $container->setParameter('csanquer_markdown.parser.cache.prefix', $config['parser']['cache']['prefix']);
        $container->setParameter('csanquer_markdown.parser.sundown.extensions', $config['parser']['sundown']['extensions']);
        $container->setParameter('csanquer_markdown.parser.sundown.flags', $config['parser']['sundown']['flags']);

        if (!empty($config['parser']['cache']['id'])) {
            $container->getDefinition('csanquer_markdown.parser')->replaceArgument(3, new Reference($config['parser']['cache']['id']));
        }
    }
}
