<?php

namespace kisRegBundle\Controller;

use kisRegBundle\Entity\Pytanie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pytanie controller.
 *
 * @Route("admin/pytanie")
 */
class PytanieController extends Controller
{
    /**
     * Lists all pytanie entities.
     *
     * @Route("/", name="admin_pytanie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pytanies = $em->getRepository('kisRegBundle:Pytanie')->findAll();

        return $this->render('pytanie/index.html.twig', array(
            'pytanies' => $pytanies,
        ));
    }

    /**
     * Creates a new pytanie entity.
     *
     * @Route("/new", name="admin_pytanie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pytanie = new Pytanie();
        $form = $this->createForm('kisRegBundle\Form\PytanieType', $pytanie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pytanie);
            $em->flush($pytanie);

            return $this->redirectToRoute('admin_pytanie_show', array('id' => $pytanie->getId()));
        }

        return $this->render('pytanie/new.html.twig', array(
            'pytanie' => $pytanie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pytanie entity.
     *
     * @Route("/{id}", name="admin_pytanie_show")
     * @Method("GET")
     */
    public function showAction(Pytanie $pytanie)
    {
        $deleteForm = $this->createDeleteForm($pytanie);

        return $this->render('pytanie/show.html.twig', array(
            'pytanie' => $pytanie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pytanie entity.
     *
     * @Route("/{id}/edit", name="admin_pytanie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pytanie $pytanie)
    {
        $deleteForm = $this->createDeleteForm($pytanie);
        $editForm = $this->createForm('kisRegBundle\Form\PytanieType', $pytanie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_pytanie_edit', array('id' => $pytanie->getId()));
        }

        return $this->render('pytanie/edit.html.twig', array(
            'pytanie' => $pytanie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pytanie entity.
     *
     * @Route("/{id}", name="admin_pytanie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pytanie $pytanie)
    {
        $form = $this->createDeleteForm($pytanie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pytanie);
            $em->flush();
        }

        return $this->redirectToRoute('admin_pytanie_index');
    }

    /**
     * Creates a form to delete a pytanie entity.
     *
     * @param Pytanie $pytanie The pytanie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pytanie $pytanie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_pytanie_delete', array('id' => $pytanie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * @Route("/{id}/deleteForm", name="admin_pytanie_delete_form")
     */
    public function createDeleteFormViewAction(Pytanie $pytanie)
    {
        return $this->render('kisRegBundle:Admin:Common/delete_form.html.twig', array(
            'form' => $this->createDeleteForm($pytanie)->createView(),
        ));
    }
}
