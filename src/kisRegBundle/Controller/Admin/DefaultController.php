<?php

namespace kisRegBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin")
 */
class DefaultController extends Controller
{
    /**
     * @Template()
     * @Route("/",name="admin_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $out = array();
        foreach (array(
            'uzytkownik','strona','skrot'
        ) as $o) {
            $out[$o.'_n'] = $em->createQuery('SELECT COUNT(o) FROM kisRegBundle:'.ucfirst($o).' o')->getSingleScalarResult();
        }
        return $out;
    }
}
