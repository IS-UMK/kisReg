<?php
namespace kisRegBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
  * @Route("/content")
  */
class ResourcePublicationController extends Controller
{
    /**
     * @Route("/files/{id}/{file_name}",name="public_file_access")
     * @Method("GET")
     */
    public function viewFileAction($id,$file_name){
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('kisRegBundle:Plik')->findOneBy(
          array(
            'id'=>$id,
            'nazwa'=>$file_name
          )
        );
        if(!$file)throw $this->createNotFoundException('Unable to find file.');
        $resp = new Response();
        $resp->headers->set('Content-Type', $file->getMime());
        $resp->setContent($file->getData());
        return $resp;
    }
    /**
     * @Route("/thumb/{size}/{id}/{file_name}",name="public_file_thumb", requirements={"size" = "\d+"})
     * @Route("/thumb/{id}/{file_name}",name="public_file_thumb_default_size", requirements={"size" = "\d+"})
     * @Method("GET")
     */
    public function thumbFileAction($id,$file_name,$size=50){
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('kisRegBundle:Plik')->findOneBy(
          array(
            'id'=>$id,
            'nazwa'=>$file_name
          )
        );
        if(!$file)throw $this->createNotFoundException('Unable to find file.');
        $resp = new Response();
        switch($file->getMime()){
          /* by file content - if thumbliner support */
          case 'image/png': case 'image/jpeg': case 'image/gif':
          case 'image/bmp':
            $resp->headers->set('Content-Type', $file->getMime());
            $thumbData = $this->get('thumbliner')->getFromPlik($file,$size);
            break;
          /* by file type */
          case 'application/zip':
            $resp->headers->set('Content-Type', 'image/png');
            $thumbData = $this->get('thumbliner')->getImageData('file_zip.png',$size);
            break;
          case 'application/pdf':
            $resp->headers->set('Content-Type', 'image/png');
            $thumbData = $this->get('thumbliner')->getImageData('file_pdf.png',$size);
            break;
          /* default */
          default:
            $resp->headers->set('Content-Type', 'image/png');
            $thumbData = $this->get('thumbliner')->getUnknown($size);
            break;
        }
        $resp->setContent($thumbData);
        return $resp;
    }
}
