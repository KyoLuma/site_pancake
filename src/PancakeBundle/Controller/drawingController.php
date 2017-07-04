<?php

namespace PancakeBundle\Controller;

use PancakeBundle\Entity\drawing;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Drawing controller.
 *
 * @Route("drawing")
 */
class drawingController extends Controller
{
    /**
     * Lists all drawing entities.
     *
     * @Route("/", name="drawing_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $drawings = $em->getRepository('PancakeBundle:drawing')->findAll();

        return $this->render('drawing/index.html.twig', array(
            'drawings' => $drawings,
        ));
    }

    /**
     * Creates a new drawing entity.
     *
     * @Route("/new", name="drawing_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $drawing = new Drawing();
        $form = $this->createForm('PancakeBundle\Form\drawingType', $drawing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($drawing);
            $em->flush();

            return $this->redirectToRoute('drawing_show', array('id' => $drawing->getId()));
        }

        return $this->render('drawing/new.html.twig', array(
            'drawing' => $drawing,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a drawing entity.
     *
     * @Route("/{id}", name="drawing_show")
     * @Method("GET")
     */
    public function showAction(drawing $drawing)
    {
        $deleteForm = $this->createDeleteForm($drawing);

        return $this->render('drawing/show.html.twig', array(
            'drawing' => $drawing,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing drawing entity.
     *
     * @Route("/{id}/edit", name="drawing_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, drawing $drawing)
    {
        $deleteForm = $this->createDeleteForm($drawing);
        $editForm = $this->createForm('PancakeBundle\Form\drawingType', $drawing);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('drawing_edit', array('id' => $drawing->getId()));
        }

        return $this->render('drawing/edit.html.twig', array(
            'drawing' => $drawing,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a drawing entity.
     *
     * @Route("/{id}", name="drawing_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, drawing $drawing)
    {
        $form = $this->createDeleteForm($drawing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($drawing);
            $em->flush();
        }

        return $this->redirectToRoute('drawing_index');
    }

    /**
     * Creates a form to delete a drawing entity.
     *
     * @param drawing $drawing The drawing entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(drawing $drawing)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('drawing_delete', array('id' => $drawing->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
