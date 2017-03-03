<?php
namespace kisRegBundle\Twig;
// use Symfony\Component\HttpKernel\Kernel;
use kisRegBundle\Helpers\MiscSorter;
use kisRegBundle\Entity\Zasob;
use kisRegBundle\Entity\Plik;

class MiscTwigExtension extends \Twig_Extension {
    public function getTests(){
        return [
            'zasobType' =>  new \Twig_Function_Method($this, 'zasobTypeCheck'),
            'instanceof' =>  new \Twig_Function_Method($this, 'isInstanceof')
        ];
    }
    public function isInstanceof($var, $instance) {
        return  $var instanceof $instance;
    }
    public function zasobTypeCheck($var, $instance) {
        if(!$var instanceof Zasob)
            return false;
        return  $var->getTyp() == Zasob::$res_types[$instance];
    }
    public function getFunctions() {
        return array(
            'static' => new \Twig_Function_Method($this, 'static_get')
        );
    }
    public function static_get($class, $property) {
        if (property_exists($class, $property)) {
            return $class::$$property;
        }
        return null;
    }
    public function miscSort($a){
        $ms = new MiscSorter();
        $ms->add($a);
        return $ms->getSorted();
    }

    public function getFilters()
    {
        return array(
            // new \Twig_SimpleFilter('imageIncludeWhitBase64', array($this, 'imageIncludeWhitBase64Filter')),
            new \Twig_SimpleFilter('base64', array($this, 'base64Filter')),
            new \Twig_SimpleFilter('smartDate',  array($this, 'smartDate')),
            new \Twig_SimpleFilter('viewUrl',  array($this, 'viewUrl')),
			new \Twig_SimpleFilter('thumbUrl',  array($this, 'thumbUrl')),
			new \Twig_SimpleFilter('geoPos',  array($this, 'geoPos')),
			new \Twig_SimpleFilter('miscSort',  array($this, 'miscSort')),
        );
    }

    // public function imageIncludeWhitBase64Filter($filePath)
    // {
    //     $realPath = $this->kernel->locateResource($filePath);
    //     $fi = new \finfo(FILEINFO_MIME_TYPE);
    //
    //     return
    //         'data:'.
    //         $fi->file($realPath).
    //         ';base64,'.
    //         $this->base64Filter(file_get_contents($realPath));
    // }
    public function geoPos($dec)
    {

        $vars = explode(".",$dec);
        $deg = $vars[0];
        $tempma = "0.".$vars[1];

        $tempma = $tempma * 3600;
        $min = floor($tempma / 60);
        $sec = $tempma - ($min*60);

        return $deg.'&deg;'.(($min<10)?'0':'').$min.'\''.(($sec<10)?'0':'').round($sec,3).'"';
    }
    public function base64Filter($data)
    {
        return base64_encode($data);
    }

    public function getName()
    {
        return 'twig_MiscTwigExtension_extension';
    }

    public function smartDate($date){
        $shortM = array('0','sty','lut','mar','kwi','maj','cze','lip','sie','wrz','paź','lis','gru');
        $now = new \DateTime('now');
        try {
            if( $now->format('Y') != $date->format('Y') ):
              return $date->format('j').' '.$shortM[$date->format('n')].' '.$date->format('Y, H:i');
            elseif ( ($now->format('j') == $date->format('j') ) && ( $now->format('n') == $date->format('n') ) ):
              return $date->format('H:i');
            else:
              return $date->format('j').' '.$shortM[$date->format('n')].', '.$date->format('H:i');
            endif;
        } catch (Exception $e) {
            return '';
        }
    }
	public function viewUrl($plik){
        if($plik == null) return '';
		return '/content/files/'.$plik->getId().'/'.$plik->getNazwa();
	}
	public function thumbUrl($plik,$rozmiar=128){
        if($plik == null) return '';
		if($rozmiar===null)
        	return '/content/thumb/'.$plik->getId().'/'.$plik->getNazwa();
        return '/content/thumb/'.$rozmiar.'/'.$plik->getId().'/'.$plik->getNazwa();
	}
}
