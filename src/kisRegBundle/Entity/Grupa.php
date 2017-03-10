<?php

namespace kisRegBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use kisRegBundle\Entity\Zajecia;
use kisRegBundle\Entity\Zapis;

/**
 * Grupa
 *
 * @ORM\Table(name="grupa")
 * @ORM\Entity(repositoryClass="kisRegBundle\Repository\GrupaRepository")
 */
class Grupa
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="opiekun", type="string", length=255)
     */
    private $opiekun;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="szkola", type="string", length=255)
     */
    private $szkola;

    /**
     * @var string
     *
     * @ORM\Column(name="telefon", type="string", length=255, nullable=true)
     */
    private $telefon;

    /**
     * @ORM\OneToMany(targetEntity="Zapis", mappedBy="grupa",cascade={"all"},cascade={"all"})
     */
    private $zapisy;

    /**
     * @var string
     *
     * @ORM\Column(name="uwagi", type="text", nullable=true)
     */
    private $uwagi;

    /**
     * @var boolval
     *
     * @ORM\Column(name="potwierdzono", type="boolean", nullable=true)
     */
    private $potwierdzono;

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
     * Set opiekun
     *
     * @param string $opiekun
     *
     * @return Grupa
     */
    public function setOpiekun($opiekun)
    {
        $this->opiekun = $opiekun;

        return $this;
    }

    /**
     * Get opiekun
     *
     * @return string
     */
    public function getOpiekun()
    {
        return $this->opiekun;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Grupa
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telefon
     *
     * @param string $telefon
     *
     * @return Grupa
     */
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;

        return $this;
    }

    /**
     * Get telefon
     *
     * @return string
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * Set uwagi
     *
     * @param string $uwagi
     *
     * @return Grupa
     */
    public function setUwagi($uwagi)
    {
        $this->uwagi = $uwagi;

        return $this;
    }

    /**
     * Get uwagi
     *
     * @return string
     */
    public function getUwagi()
    {
        return $this->uwagi;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->zapisy = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set szkola
     *
     * @param string $szkola
     *
     * @return Grupa
     */
    public function setSzkola($szkola)
    {
        $this->szkola = $szkola;

        return $this;
    }

    /**
     * Get szkola
     *
     * @return string
     */
    public function getSzkola()
    {
        return $this->szkola;
    }

    /**
     * Add zapisy
     *
     * @param \kisRegBundle\Entity\Zapis $zapisy
     *
     * @return Grupa
     */
    public function addZapisy(\kisRegBundle\Entity\Zapis $zapisy)
    {
        $this->zapisy[] = $zapisy;

        return $this;
    }

    /**
     * Remove zapisy
     *
     * @param \kisRegBundle\Entity\Zapis $zapisy
     */
    public function removeZapisy(\kisRegBundle\Entity\Zapis $zapisy)
    {
        $this->zapisy->removeElement($zapisy);
    }

    /**
     * Get zapisy
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getZapisy()
    {
        return $this->zapisy;
    }

    /**
     * Set potwierdzono
     *
     * @param boolean $potwierdzono
     *
     * @return Grupa
     */
    public function setPotwierdzono($potwierdzono)
    {
        $this->potwierdzono = $potwierdzono;

        return $this;
    }

    /**
     * Get potwierdzono
     *
     * @return boolean
     */
    public function getPotwierdzono()
    {
        return $this->potwierdzono;
    }
    public function __toString(){
        return $this->opiekun.'@'.$this->szkola;
    }
}
