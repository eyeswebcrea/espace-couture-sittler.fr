<?php
// src/Acme/DemoBundle/Menu/Builder.php
namespace Sittler\HomeBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Sittler\HomeBundle\MenuEvents;
use Sittler\HomeBundle\Event\ConfigureMenuEvent;

class MainBuilder extends ContainerAware
{
    public function build(FactoryInterface $factory)
    {
    	$em = $this->container->get("doctrine")->getEntityManager();
		
        $menu = $factory->createItem('root');
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu
        	->addChild('Accueil', array('route' => 'SittlerHomeBundle_homepage'));
			
		$vente_produit = $menu
			->addChild('Produits', array('route' => 'EyeswebcreaCatalogueBundle_list'));
		
		foreach($em->getRepository("SpipAccesContentBundle:SpipRubriques")->findBy(array("idParent" => 1, "statut" => "publie"), array("titre" => "ASC")) as $rubrique)	
		{
			$vente_produit->addChild($rubrique->getTitre() , array(
				'route' => 'EyeswebcreaCatalogueBundle_list',
				'routeParameters' => array('categorie' => $rubrique->getIdRubrique())
			));
		}	
			
		$menu
			->addChild('Services', array('route' => 'SittleHomeBundle_service'));
			
		$menu
			->addChild('Mercerie', array('route' => 'SittlerHomeBundle_mercerie'));
			
		$menu 
			->addChild('Contact', array('route' => 'SittleHomeBundle_contact'));

		//MenuEvents::CONFIGURE
		$this->container->get('event_dispatcher')->dispatch(ConfigureMenuEvent::CONFIGURE, new ConfigureMenuEvent($factory, $vente_produit));

        // ... add more children

        return $menu;
    }
	
	public function getChildrens($rubrique)
	{
		$em = $this->container->get("doctrine")->getEntityManager();
		
		return $em->getRepository("SpipAccesContentBundle:SpipRubriques")->findBy(array("idParent" => $rubrique->getIdRubrique()));
	}
}