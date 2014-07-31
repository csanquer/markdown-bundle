<?php

namespace CSanquer\Bundle\MarkdownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PreviewController extends Controller
{
    public function markdownPreviewAction()
    {
        $parser = $this->get('csanquer_markdown.parser');
        $markdown = $this->getRequest()->request->get('markdown', '');
        $html = $parser->transform($markdown);

        return new Response($html);
    }
}
