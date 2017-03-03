<?php

namespace kisRegBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use kisRegBundle\Lib\Globals;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Plik
{
    /**
     * @ORM\PreUpdate()
     */
    public function beforeUpdate(){
      $this->uploadSupport();
    }
    /**
     * @ORM\PrePersist()
     */
    public function beforeCreate(){
      $this->uploadSupport();
      $this->inicjacja();
    }
    /**
     * @ORM\PostRemove()
     */
    public function afterRemove(){
        $this->removeUpload();
    }
    public function uploadSupport(){
        if ($this->getFile() == null) {
            return;
        }
        $val_getCacheName = $this->getCacheName();
        if(!empty($val_getCacheName)){
            @unlink($this->getLocalName());
        }

       $this->setMime($this->getFile()->getMimeType());
        $val_getNazwa = $this->getNazwa();
        if(empty($val_getNazwa))
          $this->setNazwa($this->getFile()->getClientOriginalName());
        $this->setCacheName(
            uniqid(
                md5(
                    $this->getNazwa()
                ).'-',
            true)
        );
        $this->getFile()->move(
            Globals::getFileStorageDir(),
            $this->getCacheName()
        );
        $this->setWielkosc(filesize($this->getLocalName()));
        $this->file = null;
    }
    private function removeUpload(){
        if (file_exists($this->getLocalName())) {
            @unlink($this->getLocalName());
        }
    }
    private function inicjacja(){
        $this->setUtworzenie(new \DateTime());
        if(!isset($this->kolejnosc))
            $this->setKolejnosc(1);
    }
    private function sprawdzeniePoprawnosci(){
      $plik = $this->getFile();
      if($plik === null)
        return false;
      if(! $plik->isValid())
        return false;
      return true;

    }
/******************************************************************************/
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $utworzenie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nazwa;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $wielkosc;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $mime;

    /**
     * @ORM\Column(type="string", unique=true, length=255, nullable=true)
     */
    private $cacheName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kolejnosc;

/******************************************************************************/
/** interfej obsługi plików                                                  **/
/******************************************************************************/
    private function getLocalName(){
      return Globals::getFileStorageDir().DIRECTORY_SEPARATOR.$this->getCacheName();
    }
    public function getData(){
      return file_get_contents($this->getLocalName());
    }
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
    public function __toString(){
        return $this->getNazwa().'('.$this->getMime().')';
    }
	/**
	 * Alias for getData
	 */
	public function getContents(){
		return $this->getData();
	}

    /**
     * Get id
     *
     * @return guid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set utworzenie
     *
     * @param \DateTime $utworzenie
     *
     * @return Plik
     */
    public function setUtworzenie($utworzenie)
    {
        $this->utworzenie = $utworzenie;

        return $this;
    }

    /**
     * Get utworzenie
     *
     * @return \DateTime
     */
    public function getUtworzenie()
    {
        return $this->utworzenie;
    }

    /**
     * Set nazwa
     *
     * @param string $nazwa
     *
     * @return Plik
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
     * Set wielkosc
     *
     * @param integer $wielkosc
     *
     * @return Plik
     */
    public function setWielkosc($wielkosc)
    {
        $this->wielkosc = $wielkosc;

        return $this;
    }

    /**
     * Get wielkosc
     *
     * @return integer
     */
    public function getWielkosc()
    {
        return $this->wielkosc;
    }

    /**
     * Set mime
     *
     * @param string $mime
     *
     * @return Plik
     */
    public function setMime($mime)
    {
        $this->mime = $mime;

        return $this;
    }

    /**
     * Get mime
     *
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * Set cacheName
     *
     * @param string $cacheName
     *
     * @return Plik
     */
    public function setCacheName($cacheName)
    {
        $this->cacheName = $cacheName;

        return $this;
    }

    /**
     * Get cacheName
     *
     * @return string
     */
    public function getCacheName()
    {
        return $this->cacheName;
    }

    /**
     * Set kolejnosc
     *
     * @param integer $kolejnosc
     *
     * @return Plik
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
}
