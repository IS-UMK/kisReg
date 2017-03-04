<?php

namespace kisRegBundle\Controller;

use kisRegBundle\Entity\Grupa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Grupa controller.
 *
 * @Route("admin/grupa")
 */
class GrupaController extends Controller
{
    /**
     * Lists all grupa entities.
     *
     * @Route("/", name="admin_grupa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $grupas = $em->getRepository('kisRegBundle:Grupa')->findAll();

        return $this->render('grupa/index.html.twig', array(
            'grupas' => $grupas,
        ));
    }

    /**
     * Creates a new grupa entity.
     *
     * @Route("/new", name="admin_grupa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $grupa = new Grupa();
        $form = $this->createForm('kisRegBundle\Form\GrupaType', $grupa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($grupa);
            $em->flush($grupa);

            return $this->redirectToRoute('admin_grupa_show', array('id' => $grupa->getId()));
        }

        return $this->render('grupa/new.html.twig', array(
            'grupa' => $grupa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a grupa entity.
     *
     * @Route("/{id}", name="admin_grupa_show")
     * @Method("GET")
     */
    public function showAction(Grupa $grupa)
    {
        $deleteForm = $this->createDeleteForm($grupa);

        return $this->render('grupa/show.html.twig', array(
            'grupa' => $grupa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing grupa entity.
     *
     * @Route("/{id}/edit", name="admin_grupa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Grupa $grupa)
    {
        $deleteForm = $this->createDeleteForm($grupa);
        $editForm = $this->createForm('kisRegBundle\Form\GrupaType', $grupa);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_grupa_edit', array('id' => $grupa->getId()));
        }

        return $this->render('grupa/edit.html.twig', array(
            'grupa' => $grupa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a grupa entity.
     *
     * @Route("/{id}", name="admin_grupa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Grupa $grupa)
    {
        $form = $this->createDeleteForm($grupa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($grupa);
            $em->flush($grupa);
        }

        return $this->redirectToRoute('admin_grupa_index');
    }

    /**
     * Creates a form to delete a grupa entity.
     *
     * @param Grupa $grupa The grupa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Grupa $grupa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_grupa_delete', array('id' => $grupa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * @Route("/{id}/deleteForm", name="admin_grupa_delete_form")
     */
    public function createDeleteFormViewAction(Grupa $grupa)
    {
        return $this->render('kisRegBundle:Admin:Common/delete_form.html.twig', array(
            'form' => $this->createDeleteForm($grupa)->createView(),
        ));
    }
}
