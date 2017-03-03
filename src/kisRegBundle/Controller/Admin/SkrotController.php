<?php

namespace kisRegBundle\Controller\Admin;

use kisRegBundle\Entity\Skrot;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Skrot controller.
 *
 * @Route("/admin/skrot")
 */
class SkrotController extends Controller
{
    /**
     * Lists all skrot entities.
     *
     * @Route("/", name="admin_skrot_index")
     * @Route("/hightlight-{podswietl}", name="admin_skrot_index_podswietl")
     * @Method("GET")
     */
    public function indexAction(Skrot $podswietl=null)
    {
        $em = $this->getDoctrine()->getManager();

        $skrots = $em->getRepository('kisRegBundle:Skrot')->findAll();

        return $this->render('kisRegBundle:Admin:skrot/index.html.twig', array(
            'skrots' => $skrots,
            'podswietl' => $podswietl
        ));
    }

    /**
     * Creates a new skrot entity.
     *
     * @Route("/new", name="admin_skrot_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $skrot = new Skrot();
        $form = $this->createForm('kisRegBundle\Form\SkrotType', $skrot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($skrot);
            $em->flush($skrot);

            return $this->redirectToRoute('admin_skrot_index_podswietl', array('podswietl' => $skrot->getId()));
        }

        return $this->render('kisRegBundle:Admin:skrot/new.html.twig', array(
            'skrot' => $skrot,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing skrot entity.
     *
     * @Route("/{id}/edit", name="admin_skrot_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Skrot $skrot)
    {
        $deleteForm = $this->createDeleteForm($skrot);
        $editForm = $this->createForm('kisRegBundle\Form\SkrotType', $skrot);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_skrot_edit', array('id' => $skrot->getId()));
        }

        return $this->render('kisRegBundle:Admin:skrot/edit.html.twig', array(
            'skrot' => $skrot,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a skrot entity.
     *
     * @Route("/{id}", name="admin_skrot_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Skrot $skrot)
    {
        $form = $this->createDeleteForm($skrot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($skrot);
            $em->flush($skrot);
        }

        return $this->redirectToRoute('admin_skrot_index');
    }

    /**
     * Creates a form to delete a skrot entity.
     *
     * @param Skrot $skrot The skrot entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Skrot $skrot)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_skrot_delete', array('id' => $skrot->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * @Route("/{id}/deleteForm", name="admin_skrot_delete_form")
     */
    public function createDeleteFormViewAction(Skrot $skrot)
    {
        return $this->render('kisRegBundle:Admin:Common/delete_form.html.twig', array(
            'form' => $this->createDeleteForm($skrot)->createView(),
        ));
    }
}
