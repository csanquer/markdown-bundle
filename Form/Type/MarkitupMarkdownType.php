<?php

namespace Csanquer\Bundle\MarkdownBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MarkitupMarkdownType extends AbstractType
{
    /**
     * @var string
     */
    protected $defaultPreviewVar;

    public function __construct($defaultPreviewVar)
    {
        $this->defaultPreviewVar = $defaultPreviewVar;
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
                'json' => '{}',
            ))
            ->setAllowedTypes(array(
                'preview_route' => array('string'),
                'preview_var' => array('string'),
                'json' => array('string'),
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
        return 'csanquer_markitup_markdown';
    }
}
