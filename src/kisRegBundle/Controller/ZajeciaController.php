<?php

namespace kisRegBundle\Controller;

use kisRegBundle\Entity\Zajecia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Zajecium controller.
 *
 * @Route("admin/zajecia")
 */
class ZajeciaController extends Controller
{
    /**
     * Lists all zajecia entities.
     *
     * @Route("/", name="admin_zajecia_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $zajecias = $em->getRepository('kisRegBundle:Zajecia')->findAll();

        return $this->render('zajecia/index.html.twig', array(
            'zajecias' => $zajecias,
        ));
    }

    /**
     * Creates a new zajecia entity.
     *
     * @Route("/new", name="admin_zajecia_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $zajecia = new Zajecia();
        $form = $this->createForm('kisRegBundle\Form\ZajeciaType', $zajecia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zajecia);
            $em->flush($zajecia);

            return $this->redirectToRoute('admin_zajecia_show', array('id' => $zajecia->getId()));
        }

        return $this->render('zajecia/new.html.twig', array(
            'zajecia' => $zajecia,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a zajecia entity.
     *
     * @Route("/{id}", name="admin_zajecia_show")
     * @Method("GET")
     */
    public function showAction(Zajecia $zajecia)
    {
        $deleteForm = $this->createDeleteForm($zajecia);

        return $this->render('zajecia/show.html.twig', array(
            'zajecia' => $zajecia,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing zajecia entity.
     *
     * @Route("/{id}/edit", name="admin_zajecia_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Zajecia $zajecia)
    {
        $deleteForm = $this->createDeleteForm($zajecia);
        $editForm = $this->createForm('kisRegBundle\Form\ZajeciaType', $zajecia);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_zajecia_edit', array('id' => $zajecia->getId()));
        }

        return $this->render('zajecia/edit.html.twig', array(
            'zajecia' => $zajecia,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a zajecia entity.
     *
     * @Route("/{id}", name="admin_zajecia_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Zajecia $zajecia)
    {
        $form = $this->createDeleteForm($zajecia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($zajecia);
            $em->flush($zajecia);
        }

        return $this->redirectToRoute('admin_zajecia_index');
    }

    /**
     * Creates a form to delete a zajecia entity.
     *
     * @param Zajecia $zajecia The zajecia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Zajecia $zajecia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_zajecia_delete', array('id' => $zajecia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * @Route("/{id}/deleteForm", name="admin_zajeca_delete_form")
     */
    public function createDeleteFormViewAction(Zajecia $zajecia)
    {
        return $this->render('kisRegBundle:Admin:Common/delete_form.html.twig', array(
            'form' => $this->createDeleteForm($zajecia)->createView(),
        ));
    }
}
