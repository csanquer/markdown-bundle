<?php

namespace CSanquer\Bundle\MarkdownBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * generate CSS Stylesheet
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class generateStyleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('csanquer:markdown:generate-style')
            ->setDescription('Generate syntax highlighter CSS stylesheet')
            ->addArgument('target', InputArgument::OPTIONAL, 'directory where to put css files', __DIR__.'/../Resources/public/css')
            ->addOption('style', 't', InputOption::VALUE_REQUIRED, 'pygments style', 'colorful')
            ->setHelp(<<<EOT
The <info>%command.name%</info> generate CSS stylesheet for given syntax highlighter:

  <info>php %command.full_name% </info>

EOT
            );
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pygmentsStyle = $input->getOption('style');
        $target = $input->getArgument('target');
        
        $highlighter = $this->getContainer()->get('csanquer_markdown.highlighter');
        
        if ($highlighter instanceof \CSanquer\Bundle\MarkdownBundle\Highlighter\Pygments) {
            $stylesheet = $highlighter->getStyles($pygmentsStyle);
            $filename = 'pygments_'.$pygmentsStyle.'.css';
        } else {
            $stylesheet = $highlighter->getStyles();
            $filename = 'geshi.css';
        }
        
        
        $fs = new Filesystem();        
        $fs->dumpFile($target.'/'.$filename, $stylesheet);
    }
}
