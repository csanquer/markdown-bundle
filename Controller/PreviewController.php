<?php

namespace Csanquer\Bundle\MarkdownBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class PreviewController extends Controller
{
    public function markdownPreviewAction(Request $request)
    {
        $parser = $this->get('csanquer_markdown.parser');
        $markdown = $request->request->get($this->container->getParameter('csanquer_markdown.preview.var'), '');
        $html = $parser->transform($markdown);

        if ((bool) $request->request->get('use_template', $this->container->getParameter('csanquer_markdown.preview.use_template'))) {
            $response = $this->render($this->container->getParameter('csanquer_markdown.preview.template'), array(
                'content' => $html,
            ));
        } else {
            $response = new Response($html);
        }

        return $response;
    }
}
