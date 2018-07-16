<?php

namespace SiteBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        return $this->render('default/index.html.twig');
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
