<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Squid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Squid controller.
 *
 * @Route("squid")
 */
class SquidController extends Controller
{
    /**
     * Lists all squid entities.
     *
     * @Route("/", name="squid_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $squids = $em->getRepository('AppBundle:Squid')->findAll();

        return $this->render('squid/index.html.twig', array(
            'squids' => $squids,
        ));
    }

    /**
     * Creates a new squid entity.
     *
     * @Route("/new", name="squid_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $squid = new Squid();
        $form = $this->createForm('AppBundle\Form\SquidType', $squid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($squid);
            $em->flush();

            return $this->redirectToRoute('squid_show', array('id' => $squid->getId()));
        }

        return $this->render('squid/new.html.twig', array(
            'squid' => $squid,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a squid entity.
     *
     * @Route("/{id}", name="squid_show")
     * @Method("GET")
     */
    public function showAction(Squid $squid)
    {
        $deleteForm = $this->createDeleteForm($squid);

        return $this->render('squid/show.html.twig', array(
            'squid' => $squid,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing squid entity.
     *
     * @Route("/{id}/edit", name="squid_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Squid $squid)
    {
        $deleteForm = $this->createDeleteForm($squid);
        $editForm = $this->createForm('AppBundle\Form\SquidType', $squid);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('squid_edit', array('id' => $squid->getId()));
        }

        return $this->render('squid/edit.html.twig', array(
            'squid' => $squid,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a squid entity.
     *
     * @Route("/{id}", name="squid_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Squid $squid)
    {
        $form = $this->createDeleteForm($squid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($squid);
            $em->flush();
        }

        return $this->redirectToRoute('squid_index');
    }

    /**
     * Creates a form to delete a squid entity.
     *
     * @param Squid $squid The squid entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Squid $squid)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('squid_delete', array('id' => $squid->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
