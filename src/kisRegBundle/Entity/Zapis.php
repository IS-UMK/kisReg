<?php

namespace kisRegBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use kisRegBundle\Entity\Grupa;
use kisRegBundle\Entity\Zajecia;

/**
 * Zapis
 *
 * @ORM\Table(name="zapis")
 * @ORM\Entity(repositoryClass="kisRegBundle\Repository\ZapisRepository")
 */
class Zapis
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="ilosc", type="integer")
     */
    private $ilosc;

    /**
     * @ORM\ManyToOne(targetEntity="kisRegBundle\Entity\Grupa", inversedBy="zapisy")
     */
    private $grupa;

    /**
     * @ORM\ManyToOne(targetEntity="kisRegBundle\Entity\Zajecia", inversedBy="zapisy")
     */
    private $zajecia;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ilosc
     *
     * @param integer $ilosc
     *
     * @return Zapis
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    /**
     * Get ilosc
     *
     * @return int
     */
    public function getIlosc()
    {
        return $this->ilosc;
    }

    /**
     * Set grupa
     *
     * @param \kisRegBundle\Entity\Grupa $grupa
     *
     * @return Zapis
     */
    public function setGrupa(\kisRegBundle\Entity\Grupa $grupa = null)
    {
        $this->grupa = $grupa;

        return $this;
    }

    /**
     * Get grupa
     *
     * @return \kisRegBundle\Entity\Grupa
     */
    public function getGrupa()
    {
        return $this->grupa;
    }

    /**
     * Set zajecia
     *
     * @param \kisRegBundle\Entity\Zajecia $zajecia
     *
     * @return Zapis
     */
    public function setZajecia(\kisRegBundle\Entity\Zajecia $zajecia = null)
    {
        $this->zajecia = $zajecia;

        return $this;
    }

    /**
     * Get zajecia
     *
     * @return \kisRegBundle\Entity\Zajecia
     */
    public function getZajecia()
    {
        return $this->zajecia;
    }
}
