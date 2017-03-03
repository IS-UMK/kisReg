<?php

namespace kisRegBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zajecia
 *
 * @ORM\Table(name="zajecia")
 * @ORM\Entity(repositoryClass="kisRegBundle\Repository\ZajeciaRepository")
 */
class Zajecia
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
     * @var string
     *
     * @ORM\Column(name="nazwa", type="string", length=255)
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="opis", type="text")
     */
    private $opis;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="poczatek", type="time")
     */
    private $poczatek;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="koniec", type="time")
     */
    private $koniec;

    /**
     * @var int
     *
     * @ORM\Column(name="limitMiejsc", type="integer", nullable=true)
     */
    private $limitMiejsc;


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
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return Zajecia
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Set opis
     *
     * @param string $opis
     *
     * @return Zajecia
     */
    public function setOpis($opis)
    {
        $this->opis = $opis;

        return $this;
    }

    /**
     * Get opis
     *
     * @return string
     */
    public function getOpis()
    {
        return $this->opis;
    }

    /**
     * Set poczatek
     *
     * @param \DateTime $poczatek
     *
     * @return Zajecia
     */
    public function setPoczatek($poczatek)
    {
        $this->poczatek = $poczatek;

        return $this;
    }

    /**
     * Get poczatek
     *
     * @return \DateTime
     */
    public function getPoczatek()
    {
        return $this->poczatek;
    }

    /**
     * Set koniec
     *
     * @param \DateTime $koniec
     *
     * @return Zajecia
     */
    public function setKoniec($koniec)
    {
        $this->koniec = $koniec;

        return $this;
    }

    /**
     * Get koniec
     *
     * @return \DateTime
     */
    public function getKoniec()
    {
        return $this->koniec;
    }

    /**
     * Set limitMiejsc
     *
     * @param integer $limitMiejsc
     *
     * @return Zajecia
     */
    public function setLimitMiejsc($limitMiejsc)
    {
        $this->limitMiejsc = $limitMiejsc;

        return $this;
    }

    /**
     * Get limitMiejsc
     *
     * @return int
     */
    public function getLimitMiejsc()
    {
        return $this->limitMiejsc;
    }
}

