<?php

namespace Csanquer\Bundle\MarkdownBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $template = 'CsanquerMarkdownBundle:Form:fields.html.twig';
        $resources = $container->getParameter('twig.form.resources');
        if (!in_array($template, $resources)) {
            // If form_div_layout.html.twig is found, insert template right after
            if (($key = array_search('form_div_layout.html.twig', $resources)) !== false) {
                array_splice($resources, ++$key, 0, $template);
            } else {
                array_unshift($resources, $template);
            }

            $container->setParameter('twig.form.resources', $resources);
        }
    }
}
