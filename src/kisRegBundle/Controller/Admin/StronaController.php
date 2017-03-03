<?php

namespace kisRegBundle\Controller\Admin;

use kisRegBundle\Entity\Strona;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Strona controller.
 *
 * @Route("/admin/strona")
 */
class StronaController extends Controller
{
    /**
     * Lists all strona entities.
     *
     * @Route("/", name="admin_strona_index")
     * @Route("/hightlight-{podswietl}", name="admin_strona_index_podswietl")
     * @Method("GET")
     */
    public function indexAction(Strona $podswietl=null)
    {
        $em = $this->getDoctrine()->getManager();

        $stronas = $em->getRepository('kisRegBundle:Strona')->findAll();

        return $this->render('kisRegBundle:Admin:strona/index.html.twig', array(
            'stronas' => $stronas,
            'podswietl' => $podswietl
        ));
    }

    /**
     * Creates a new strona entity.
     *
     * @Route("/new", name="admin_strona_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $strona = new Strona();
        $form = $this->createForm('kisRegBundle\Form\StronaType', $strona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($strona);
            $em->flush($strona);

            return $this->redirectToRoute('admin_strona_index_podswietl', array('podswietl' => $strona->getId()));
        }

        return $this->render('kisRegBundle:Admin:strona/new.html.twig', array(
            'strona' => $strona,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing strona entity.
     *
     * @Route("/{id}/edit", name="admin_strona_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Strona $strona)
    {
        $deleteForm = $this->createDeleteForm($strona);
        $editForm = $this->createForm('kisRegBundle\Form\StronaType', $strona);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_strona_edit', array('id' => $strona->getId()));
        }

        return $this->render('kisRegBundle:Admin:strona/edit.html.twig', array(
            'strona' => $strona,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a strona entity.
     *
     * @Route("/{id}", name="admin_strona_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Strona $strona)
    {
        $form = $this->createDeleteForm($strona);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($strona);
            $em->flush($strona);
        }

        return $this->redirectToRoute('admin_strona_index');
    }

    /**
     * Creates a form to delete a strona entity.
     *
     * @param Strona $strona The strona entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Strona $strona)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_strona_delete', array('id' => $strona->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * @Route("/{id}/deleteForm", name="admin_strona_delete_form")
     */
    public function createDeleteFormViewAction(Strona $strona)
    {
        return $this->render('kisRegBundle:Admin:Common/delete_form.html.twig', array(
            'form' => $this->createDeleteForm($strona)->createView(),
        ));
    }
}
