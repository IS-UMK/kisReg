<?php

namespace kisRegBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pytanie
 *
 * @ORM\Table(name="pytanie")
 * @ORM\Entity(repositoryClass="kisRegBundle\Repository\PytanieRepository")
 */
class Pytanie
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
     * @ORM\Column(name="tresc", type="text", unique=true)
     */
    private $tresc;

    /**
     * @var string
     *
     * @ORM\Column(name="odpowiedz_A", type="text")
     */
    private $odpowiedzA;

    /**
     * @var string
     *
     * @ORM\Column(name="odpowiedz_B", type="text")
     */
    private $odpowiedzB;

    /**
     * @var string
     *
     * @ORM\Column(name="odpowiedz_C", type="text")
     */
    private $odpowiedzC;

    /**
     * @var string
     *
     * @ORM\Column(name="odpowiedz_D", type="text")
     */
    private $odpowiedzD;

    /**
     * @var int
     *
     * @ORM\Column(name="poprawnaOdpowiedz", length=1, nullable=false)
     */
    private $poprawnaOdpowiedz;

    /**
     * @var int
     *
     * @ORM\Column(name="kolejnosc", type="integer")
     */
    private $kolejnosc;

    /**
     * @var boolval
     *
     * @ORM\Column(name="potwierdzono", type="boolean", nullable=true)
     */
    private $aktywne;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tresc
     *
     * @param string $tresc
     *
     * @return Pytanie
     */
    public function setTresc($tresc)
    {
        $this->tresc = $tresc;

        return $this;
    }

    /**
     * Get tresc
     *
     * @return string
     */
    public function getTresc()
    {
        return $this->tresc;
    }

    /**
     * Set odpowiedzA
     *
     * @param string $odpowiedzA
     *
     * @return Pytanie
     */
    public function setOdpowiedzA($odpowiedzA)
    {
        $this->odpowiedzA = $odpowiedzA;

        return $this;
    }

    /**
     * Get odpowiedzA
     *
     * @return string
     */
    public function getOdpowiedzA()
    {
        return $this->odpowiedzA;
    }

    /**
     * Set odpowiedzB
     *
     * @param string $odpowiedzB
     *
     * @return Pytanie
     */
    public function setOdpowiedzB($odpowiedzB)
    {
        $this->odpowiedzB = $odpowiedzB;

        return $this;
    }

    /**
     * Get odpowiedzB
     *
     * @return string
     */
    public function getOdpowiedzB()
    {
        return $this->odpowiedzB;
    }

    /**
     * Set odpowiedzC
     *
     * @param string $odpowiedzC
     *
     * @return Pytanie
     */
    public function setOdpowiedzC($odpowiedzC)
    {
        $this->odpowiedzC = $odpowiedzC;

        return $this;
    }

    /**
     * Get odpowiedzC
     *
     * @return string
     */
    public function getOdpowiedzC()
    {
        return $this->odpowiedzC;
    }

    /**
     * Set odpowiedzD
     *
     * @param string $odpowiedzD
     *
     * @return Pytanie
     */
    public function setOdpowiedzD($odpowiedzD)
    {
        $this->odpowiedzD = $odpowiedzD;

        return $this;
    }

    /**
     * Get odpowiedzD
     *
     * @return string
     */
    public function getOdpowiedzD()
    {
        return $this->odpowiedzD;
    }

    /**
     * Set poprawnaOdpowiedz
     *
     * @param string $poprawnaOdpowiedz
     *
     * @return Pytanie
     */
    public function setPoprawnaOdpowiedz($poprawnaOdpowiedz)
    {
        $this->poprawnaOdpowiedz = $poprawnaOdpowiedz;

        return $this;
    }

    /**
     * Get poprawnaOdpowiedz
     *
     * @return string
     */
    public function getPoprawnaOdpowiedz()
    {
        return $this->poprawnaOdpowiedz;
    }

    /**
     * Set kolejnosc
     *
     * @param integer $kolejnosc
     *
     * @return Pytanie
     */
    public function setKolejnosc($kolejnosc)
    {
        $this->kolejnosc = $kolejnosc;

        return $this;
    }

    /**
     * Get kolejnosc
     *
     * @return integer
     */
    public function getKolejnosc()
    {
        return $this->kolejnosc;
    }

    /**
     * Set aktywne
     *
     * @param boolean $aktywne
     *
     * @return Pytanie
     */
    public function setAktywne($aktywne)
    {
        $this->aktywne = $aktywne;

        return $this;
    }

    /**
     * Get aktywne
     *
     * @return boolean
     */
    public function getAktywne()
    {
        return $this->aktywne;
    }
}
