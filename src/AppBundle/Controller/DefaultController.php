<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use AppBundle\Entity\Armadillo;
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

    /**
    * @Route("/armadillos", name="entity")
    */

    public function showArmadillosAction(){

        $repository = $this->getDoctrine()->getRepository(Armadillo::class);
        $arma = $repository->findAll();
        
        return $this->render('AppBundle:Default:entity.html.twig', array(
            'arma' => $arma
        ));
    }

    /**
    * @Route("/armadillos/{id}", name="entity-solo")
    */

    public function showArmaAction($id){
        $repository = $this->getDoctrine()->getRepository(Armadillo::class);
        $arma = $repository->findOneById($id);

        return $this->render('AppBundle:Default:entity-solo.html.twig', array(
            'arma' => $arma
        ));

    }

    /**
    * @Route("armadillo/new", name="entity-new")
    */

    public function newEntityAction(Request $request){
        $arma = new Armadillo();

        // $form = $this->createFormBuilder($arma)
        //     ->add('name', TextType::class)
        //     ->add('birthday', DateType::class)
        //     ->add('description', TextType::class)
        //     ->add('age', IntegerType::class)
        //     ->add('adult')
        //     ->add('save', SubmitType::class, array('label' => 'Create Post'))
        //     ->getform();

        $form = $this->createForm('AppBundle\Form\ArmadilloType', $arma);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($arma);
            $em->flush();
        
            return $this->redirectToRoute('entity-solo', array('id' => $arma->getId()));
        }
        return $this->render('AppBundle:Default:entity-new.html.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
    * @Route("armadillo/update/{id}", name="entity-update")
    */

    public function updateEntityAction(Request $request, $id){
        $repository = $this->getDoctrine()->getRepository(Armadillo::class);
        $arma = $repository->findOneById($id);

        $form = $this->createForm('AppBundle\Form\ArmadilloType', $arma);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($arma);
            $em->flush();
        
            return $this->redirectToRoute('entity-solo', array('id' => $arma->getId()));
        }

        return $this->render('AppBundle:Default:entity-new.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
