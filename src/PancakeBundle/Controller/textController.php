<?php

namespace PancakeBundle\Controller;

use PancakeBundle\Entity\text;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Text controller.
 *
 * @Route("text")
 */
class textController extends Controller
{
    /**
     * Lists all text entities.
     *
     * @Route("/", name="text_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $texts = $em->getRepository('PancakeBundle:text')->findAll();

        return $this->render('text/index.html.twig', array(
            'texts' => $texts,
        ));
    }

    /**
     * Creates a new text entity.
     *
     * @Route("/new", name="text_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $text = new Text();
        $form = $this->createForm('PancakeBundle\Form\textType', $text);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($text);
            $em->flush();

            return $this->redirectToRoute('text_show', array('id' => $text->getId()));
        }

        return $this->render('text/new.html.twig', array(
            'text' => $text,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a text entity.
     *
     * @Route("/{id}", name="text_show")
     * @Method("GET")
     */
    public function showAction(text $text)
    {
        $deleteForm = $this->createDeleteForm($text);

        return $this->render('text/show.html.twig', array(
            'text' => $text,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing text entity.
     *
     * @Route("/{id}/edit", name="text_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, text $text)
    {
        $deleteForm = $this->createDeleteForm($text);
        $editForm = $this->createForm('PancakeBundle\Form\textType', $text);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('text_edit', array('id' => $text->getId()));
        }

        return $this->render('text/edit.html.twig', array(
            'text' => $text,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a text entity.
     *
     * @Route("/{id}", name="text_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, text $text)
    {
        $form = $this->createDeleteForm($text);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($text);
            $em->flush();
        }

        return $this->redirectToRoute('text_index');
    }

    /**
     * Creates a form to delete a text entity.
     *
     * @param text $text The text entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(text $text)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('text_delete', array('id' => $text->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
