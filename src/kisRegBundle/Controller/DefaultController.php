<?php

namespace kisRegBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use kisRegBundle\Entity\Zajecia;

class DefaultController extends Controller
{
    private function loadStrony($strony){
        $em = $this->getDoctrine()->getManager();
        $dane = [];
        $repo = $em->getRepository('kisRegBundle:Strona');
        foreach($strony as $nazwaStrony){
            $strona = $repo->findOneByNazwa($nazwaStrony);
            if($strona==false){
                $dane[$nazwaStrony] = 'Utwórz stronę o nazwie <b>'.$nazwaStrony.'</b>';
            } else {
                $tempStr = $strona->getTresc();
                if(empty($tempStr))
                    $dane[$nazwaStrony] = '';
                else
                    $dane[$nazwaStrony] = $this->get('twig')->createTemplate($tempStr)->render([]);
            }
        }
        return $dane;
    }
    /**
     * @Template()
     * @Route("/",name="frontPage")
     */
    public function indexAction(){
        return $this->loadStrony([
            'glowna_0',
            'glowna_1',
            'glowna_2',
            'glowna_3',
            'glowna_4'
        ]);
    }
    /**
     * @Template()
     * @Route("/program.html",name="program")
     */
    public function programAction(){
        $em = $this->getDoctrine()->getManager();
        $dane = [];
        $repo = $em->getRepository('kisRegBundle:Zajecia');

        $dane['zajecia'] = $repo->findAllGroupedByName();

        return $dane;
    }
    /**
     * @Template()
     * @Route("/zajecia-{id}.html",name="zajecia")
     */
    public function zajeciaAction(Zajecia $zajecia){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('kisRegBundle:Zajecia');
        $podobne = $repo->findByNazwa($zajecia->getNazwa());
        $all = $repo->findAllGroupedByName();
        return ['all'=>$all,'podobne'=>$podobne,'zajecia'=>$zajecia];
    }
    /**
     * @Route("/{name}-p.html", name="strona")
     * @Template()
     */
    public function pageAction(Request $request,$name){
        $em = $this->getDoctrine()->getManager();
        $strona = $em->getRepository('kisRegBundle:Strona')->findOneByNazwa($name);
        if($strona){
            $tempStr = $strona->getTresc();
            if(!empty($tempStr))
                $strona->setTresc($this->get('twig')->createTemplate($tempStr)->render([]));
            return ['strona' => $strona];
        }
        throw $this->createNotFoundException('Strona nie istnieje!');
    }
    /**
     * @Route("/kontakt.html", name="kontakt")
     * @Template()
     */
    public function kontaktAction(Request $request){
        $form = $this
            ->createFormBuilder()
            ->add('name',TextType::class,array('label'=>'Imię i Nazwisko',
                'attr'=>array(
                    'placeholder'=>'Twoje imie i nazwisko...'
                )
            ))
            ->add('email',EmailType::class,array('label'=>'Email',
                'attr'=>array(
                    'placeholder'=>'Twój email...'
                )
            ))
            ->add('msg',TextareaType::class,array(
                'attr'=>array(
                    'style'=>'height:180px;',
                    'placeholder'=>'Twoja wiadomość...'
                ),
                'label'=>'Wiadomość'
            ))
            ->add('recaptcha', EWZRecaptchaType::class,array(
                'mapped'      => false,
                'constraints' => array(
                        new RecaptchaTrue()
                        )
                    )
                )
            ->add('send', SubmitType::class,array('label'=>'Wyślij' ))
            ->getForm();
        $outMsg = '';
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $outMsg = 'Wiadomość została wysłana';
            $data = $form->getData();
            $message = \Swift_Message::newInstance()
                ->setSubject('Wiadomość z serwisu')
                ->setTo('bartek@comea.pl')
                ->setBody(
                    $this->renderView(
                        'kisRegBundle:Emails:kontakt.html.twig',
                        $data
                    ),
                    'text/html'
                )
                ->addPart(
                    $this->renderView(
                        'kisRegBundle:Emails:kontakt.txt.twig',
                        $data
                    ),
                    'text/plain'
                )
            ;
            $this->get('mailer')->send($message);
        }
        $out = $this->loadStrony([
            'kontakt_0',
            'kontakt_1',
            'kontakt_2',
            'kontakt_3',
            'kontakt_4'
        ]);
        $out['form'] = $form->createView();
        $out['msg'] = $outMsg;
        return $out;
    }
    /**
     * @Route("/{name}.html", name="skrot")
     */
    public function skrotAction(Request $request,$name){
        $em = $this->getDoctrine()->getManager();
        $skrot = $em->getRepository('kisRegBundle:Skrot')->findOneByNazwa($name);
        if($skrot){
            $subRequest = Request::create($skrot->getCel());
            $session = $request->getSession();
            $subRequest->setSession($session);
            return $this->get('kernel')->handle(
                $subRequest,
                HttpKernelInterface::SUB_REQUEST,
                false
            );
        }
        throw $this->createNotFoundException('Strona nie istnieje!');
    }
}
