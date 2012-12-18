<?php

namespace Sittler\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('SittlerHomeBundle:Default:index.html.twig');
    }
	
	public function viewPageServiceAction()
	{
		return $this->render("SittlerHomeBundle:Default:service.html.twig");
	}
	
	public function viewPageContactAction()
	{
		return $this->render("SittlerHomeBundle:Default:contact.html.twig");
	}
	
	public function viewPageMercerieAction()
	{
		return $this->render("SittlerHomeBundle:Default:mercerie.html.twig");
	}	
}
