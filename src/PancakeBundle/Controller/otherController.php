<?php

namespace PancakeBundle\Controller;

use PancakeBundle\Entity\other;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Other controller.
 *
 * @Route("other")
 */
class otherController extends Controller
{
    /**
     * Lists all other entities.
     *
     * @Route("/", name="other_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $others = $em->getRepository('PancakeBundle:other')->findAll();

        return $this->render('other/index.html.twig', array(
            'others' => $others,
        ));
    }

    /**
     * Creates a new other entity.
     *
     * @Route("/new", name="other_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $other = new Other();
        $form = $this->createForm('PancakeBundle\Form\otherType', $other);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($other);
            $em->flush();

            return $this->redirectToRoute('other_show', array('id' => $other->getId()));
        }

        return $this->render('other/new.html.twig', array(
            'other' => $other,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a other entity.
     *
     * @Route("/{id}", name="other_show")
     * @Method("GET")
     */
    public function showAction(other $other)
    {
        $deleteForm = $this->createDeleteForm($other);

        return $this->render('other/show.html.twig', array(
            'other' => $other,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing other entity.
     *
     * @Route("/{id}/edit", name="other_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, other $other)
    {
        $deleteForm = $this->createDeleteForm($other);
        $editForm = $this->createForm('PancakeBundle\Form\otherType', $other);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('other_edit', array('id' => $other->getId()));
        }

        return $this->render('other/edit.html.twig', array(
            'other' => $other,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a other entity.
     *
     * @Route("/{id}", name="other_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, other $other)
    {
        $form = $this->createDeleteForm($other);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($other);
            $em->flush();
        }

        return $this->redirectToRoute('other_index');
    }

    /**
     * Creates a form to delete a other entity.
     *
     * @param other $other The other entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(other $other)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('other_delete', array('id' => $other->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
