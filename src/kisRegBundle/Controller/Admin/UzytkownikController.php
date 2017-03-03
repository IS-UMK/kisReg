<?php

namespace kisRegBundle\Controller\Admin;

use kisRegBundle\Entity\Uzytkownik;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Uzytkownik controller.
 *
 * @Route("admin/uzytkownik")
 */
class UzytkownikController extends Controller
{
    /**
     * Lists all uzytkownik entities.
     *
     * @Route("/", name="admin_uzytkownik_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $uzytkowniks = $em->getRepository('kisRegBundle:Uzytkownik')->findAll();

        return $this->render('kisRegBundle:Admin:uzytkownik/index.html.twig', array(
            'uzytkowniks' => $uzytkowniks,
        ));
    }

    /**
     * Creates a new uzytkownik entity.
     *
     * @Route("/new", name="admin_uzytkownik_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $uzytkownik = new Uzytkownik();
        $form = $this->createForm('kisRegBundle\Form\UzytkownikType', $uzytkownik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');

            $em = $this->getDoctrine()->getManager();
            $em->persist($uzytkownik);

            $userManager->updateUser($uzytkownik,false);
            $em->flush($uzytkownik);

            return $this->redirectToRoute('admin_uzytkownik_edit', array('id' => $uzytkownik->getId()));
        }

        return $this->render('kisRegBundle:Admin:uzytkownik/new.html.twig', array(
            'uzytkownik' => $uzytkownik,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing uzytkownik entity.
     *
     * @Route("/{id}/edit", name="admin_uzytkownik_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Uzytkownik $uzytkownik)
    {
        $userOld = $this->getDoctrine()->getRepository('kisRegBundle:Uzytkownik')->findOneBy(['id' => $uzytkownik->getId()]);
        $oldPassword = $userOld->getPassword();

        $deleteForm = $this->createDeleteForm($uzytkownik);
        $editForm = $this->createForm('kisRegBundle\Form\UzytkownikType', $uzytkownik);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if(empty($editForm->get('password')->getData())){
                $uzytkownik->setPassword($oldPassword);
            }

            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($uzytkownik,false);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_uzytkownik_edit', array('id' => $uzytkownik->getId()));
        }

        return $this->render('kisRegBundle:Admin:uzytkownik/edit.html.twig', array(
            'uzytkownik' => $uzytkownik,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a uzytkownik entity.
     *
     * @Route("/{id}", name="admin_uzytkownik_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Uzytkownik $uzytkownik)
    {
        $form = $this->createDeleteForm($uzytkownik);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($uzytkownik);
            $em->flush($uzytkownik);
        }

        return $this->redirectToRoute('admin_uzytkownik_index');
    }

    /**
     * Creates a form to delete a uzytkownik entity.
     *
     * @param Uzytkownik $uzytkownik The uzytkownik entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Uzytkownik $uzytkownik)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_uzytkownik_delete', array('id' => $uzytkownik->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/{id}/deleteForm", name="admin_uzytkownik_delete_form")
     */
    public function createDeleteFormViewAction(Uzytkownik $uzytkownik)
    {
        return $this->render('kisRegBundle:Admin:Common/delete_form.html.twig', array(
            'form' => $this->createDeleteForm($uzytkownik)->createView(),
        ));
    }
}
