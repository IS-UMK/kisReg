<?php

namespace kisRegBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use kisRegBundle\Entity\Plik;


/**
  * @Route("/files")
  */
class PlikController extends Controller
{
    /**
     * @Route("/{id}",name="app_get_file")
     * @Template()
     */
    public function getFile($id){
      $em = $this->getDoctrine()->getManager();

      $plik = $em->getRepository('kisRegBundle:Plik')->find($id);

      if (!$plik) {
          throw $this->createNotFoundException('Unable to find Plik entity.');
      }

      $headers = array(
          'Content-Type' => $plik->getMime(),
          'Content-Disposition' => 'inline; filename="'.$plik->getNazwa().'"'
      );

      return new Response($plik->getContents(), 200, $headers);
   }

}
