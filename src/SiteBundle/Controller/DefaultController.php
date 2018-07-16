<?php

namespace SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Site/Default/index.html.twig');
    }
    
    public function faqAction(Request $request)
    {
        return $this->render('@Site/default/faq.html.twig');
    }
    
    public function cguAction(Request $request)
    {
        return $this->render('@Site/default/cgu.html.twig');
    }
}
