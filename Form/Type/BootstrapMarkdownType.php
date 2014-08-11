<?php

namespace Csanquer\Bundle\MarkdownBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BootstrapMarkdownType extends AbstractType
{
    /**
     * @var string
     */
    protected $defaultPreviewVar;

    /**
     * @var string
     */
    protected $defautIcons;

    public function __construct($defaultPreviewVar = 'markdown', $defautIcons = 'glyph')
    {
        $this->defaultPreviewVar = $defaultPreviewVar;
        $this->defautIcons = $defautIcons;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (preg_match('/\{.*\}/', $options['json']) === false) {
            throw new InvalidArgumentException('The json option must be a valid json object string.');
        }

        $view->vars['preview_route'] = $options['preview_route'];
        $view->vars['preview_var'] = $options['preview_var'];
        $view->vars['language'] = $options['language'];
        $view->vars['iconlibrary'] = $options['iconlibrary'];
        $view->vars['json'] = $options['json'];
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                    'preview_route' => 'csanquer_markdown_preview',
                    'preview_var' => $this->defaultPreviewVar,
                    'language' => substr(\Locale::getDefault(), 0, 2),
                    'iconlibrary' => $this->defautIcons,
                    'json' => '{}',
                ))
            ->setAllowedTypes(array(
                'preview_route' => array('string'),
                'preview_var' => array('string'),
                'language' => array('string'),
                'json' => array('string'),
            ))
            ->setAllowedValues(array(
                'iconlibrary' => array('glyph', 'fa'),
            ))
        ;
    }

    public function getParent()
    {
        return 'textarea';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'csanquer_bootstrap_markdown';
    }
}
