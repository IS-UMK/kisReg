<?php
namespace kisRegBundle\Twig;
use kisRegBundle\Helpers\MiscSorter;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use kisRegBundle\Entity\Skrot;

class ShorterTwigExtension extends \Twig_Extension {
    private $router;
    private $em;
    private $allowedChar = 'qwertyuiopasdfghjklzxcvbnm1234567890';
    private $replace = [
        ['ę','ó','ą','ś','ł','ż','ź','ć','ń','Ę','Ó','Ą','Ś','Ł','Ż','Ź','Ć','Ń'],
        ['e','o','a','s','l','z','z','c','n','E','O','A','S','L','Z','Z','C','N']
    ];

    public function __construct(EntityManager $em,Router  $router){
        $this->em = $em;
        $this->router = $router;
    }

    public function getFilters() {
        return array(
			new \Twig_SimpleFilter('cutUrl',  array($this, 'cutUrl')),
        );
    }
    public function cutUrl($target,$base_name=false) {
        $skrot = $this->em->getRepository('kisRegBundle:Skrot')->findOneByCel($target);
        if($skrot==FALSE){
            if($base_name===false){
                $base_name = $target->__toString();
            }
            if(!is_string($base_name)){
                $base_name = $base_name->__toString();
            }
            $base_name = strtolower($base_name);

            $base_name = str_replace(
                $this->replace[0],
                $this->replace[1],
                $base_name
            );
            for($i=0;$i<strlen($base_name);$i++){
                if(strstr($this->allowedChar,$base_name{$i})===FALSE){
                    $base_name{$i} = '-';
                }
            }
            $base_name = trim($base_name);

            $base_name = preg_replace('/-{2,}/', '-',$base_name);

            $sufix = '';
            $n = 0;

            while($this->em->getRepository('kisRegBundle:Skrot')->findOneByNazwa($base_name.$sufix)){
                $n++;
                $sufix = '-'.$n;
            }
            $skrot = new Skrot();
            $skrot->setCel($target);
            $skrot->setNazwa($base_name.$sufix);
            $this->em->persist($skrot);
            $this->em->flush($skrot);
        }
        return $this->router->generate('skrot',['name'=>$skrot->getNazwa()]);
    }
}
