<?php

namespace CSanquer\Bundle\MarkdownBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('csanquer_parsedown');

        $rootNode
            ->children()
                ->arrayNode('parser')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('type')
                            ->values(array('parsedown', 'sundown'))
                            ->defaultValue('parsedown')
                        ->end()
                        ->booleanNode('use_highlighter')->defaultTrue()->end()
                        ->arrayNode('cache')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('id')->defaultNull()->end()
                                ->integerNode('ttl')->min(0)->defaultValue(0)->end()
                                ->scalarNode('prefix')->defaultValue('markdown')->end()
                            ->end()
                        ->end()
                        ->arrayNode('sundown')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('extensions')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->booleanNode('no_intra_emphasis')->defaultFalse()->end()
                                        ->booleanNode('tables')->defaultTrue()->end()
                                        ->booleanNode('fenced_code_blocks')->defaultTrue()->end()
                                        ->booleanNode('autolink')->defaultTrue()->end()
                                        ->booleanNode('strikethrough')->defaultTrue()->end()
                                        ->booleanNode('lax_html_blocks')->defaultFalse()->end()
                                        ->booleanNode('space_after_headers')->defaultTrue()->end()
                                        ->booleanNode('superscript')->defaultFalse()->end()
                                    ->end()
                                ->end()
                                ->arrayNode('flags')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->booleanNode('filter_html')->defaultFalse()->end()
                                        ->booleanNode('no_images')->defaultFalse()->end()
                                        ->booleanNode('no_links')->defaultFalse()->end()
                                        ->booleanNode('no_styles')->defaultFalse()->end()
                                        ->booleanNode('safe_links_only')->defaultFalse()->end()
                                        ->booleanNode('with_toc_data')->defaultFalse()->end()
                                        ->booleanNode('hard_wrap')->defaultTrue()->end()
                                        ->booleanNode('xhtml')->defaultTrue()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('highlighter')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('type')
                            ->values(array('geshi', 'pygments'))
                            ->defaultValue('geshi')
                        ->end()
                        ->scalarNode('pygmentize_bin')->defaultValue('/usr/bin/pygmentize')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
