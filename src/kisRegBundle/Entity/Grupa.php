<?php

namespace kisRegBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="telefon", type="string", length=255, nullable=true)
     */
    private $telefon;

    /**
     * @var string
     *
     * @ORM\Column(name="uwagi", type="text", nullable=true)
     */
    private $uwagi;


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
}
