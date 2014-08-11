<?php

namespace Csanquer\Bundle\MarkdownBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Csanquer\Bundle\MarkdownBundle\DependencyInjection\Compiler\FormPass;

class CsanquerMarkdownBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FormPass());
    }
}
