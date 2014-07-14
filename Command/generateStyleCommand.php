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
        $defaultTarget = __DIR__.'/../Resources/public/css';
        
        $this
            ->setName('csanquer:markdown:generate-style')
            ->setDescription('Generate syntax highlighter CSS stylesheet')
            ->addArgument('target', InputArgument::OPTIONAL, 'directory where to put css files', $defaultTarget)
            ->setHelp(<<<EOT
The <info>%command.name%</info> generate CSS stylesheet for given syntax highlighter:

  <info>php %command.full_name% $defaultTarget</info>

EOT
            );
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $target = $input->getArgument('target');
        
        $highlighter = $this->getContainer()->get('csanquer_markdown.highlighter');
        
        $files = array();
        if ($highlighter instanceof \CSanquer\Bundle\MarkdownBundle\Highlighter\Pygments) {
            $styles = $highlighter->getAvailableStyles();
            foreach ($styles as $style) {
                $files['pygments_'.$style] = $highlighter->getStylesheets(array('style' => $style));
            }
        } elseif ($highlighter instanceof \CSanquer\Bundle\MarkdownBundle\Highlighter\Geshi) {
            $files['geshi'] = $highlighter->getStylesheets();
        }
        
        $fs = new Filesystem();
        foreach ($files as $file => $stylesheet) {
            $fs->dumpFile($target.'/'.$file.'.css', $stylesheet);
        }
    }
}
