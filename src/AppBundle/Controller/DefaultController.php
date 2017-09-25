<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    
    /**
    * @Route("/", name="welcome")
    */
    public function homepageAction(){
        $array = [];
        $exos = scandir(__DIR__."/../Resources/views/Default/");
        foreach($exos as $key => $value) {
            if ($key === 0 OR $key === 1) {}
            else {
                $value = str_replace(".html.twig", "", $value);
                $array[] = $value;
            }
        }
        return $this->render('AppBundle:Default:welcome.html.twig', array(
            'array' => $array
        ));
    }

    /**
     * @Route("/lucky/number/{max}", 
     *name="number",
     *defaults={"max": 100}, 
     *requirements={"max": "\d+"})  
     *
     *
     */
    public function numberAction($max)
    {
        $number = mt_rand(0, $max);
        return $this->render('AppBundle:Default:number.html.twig', array(
            
            'number' => $number
        ));
    }
    
    /**
    * @Route("/blog/{title}/{year}/{_locale}",
    * name="blog",
    * requirements={
    *     "year": "\d{4}", 
    *     "_locale": "en|fr",
    *     "title": "^[a-z0-9-]+$"})
    *
    */
    public function blogAction($title, $year, $_locale)
    {
        
        return $this->render('AppBundle:Default:blog.html.twig', array(
            'title' => $title,
            'year' => $year,
            '_locale' => $_locale
        ));
    }

    /**
    * @Route("/template", name="template")
    */
    public function templateAction()
    {
        
        return $this->render('AppBundle:Default:template.html.twig');
    }
}
