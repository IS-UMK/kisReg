<?php
namespace kisRegBundle\Services;
// use Symfony\Component\HttpKernel\Config\FileLocator;
use Symfony\Component\Config\FileLocator;
use kisRegBundle\Entity\Plik;

class ThumblinerService
{
    private $fileLocator;
    private $cacheDir;
    public function __construct(FileLocator $fileLocator,$cacheDir){
      $this->fileLocator = $fileLocator;
      $this->cacheDir = $cacheDir;
    }
    public function getUnknown($size){
      return $this->getImageData('base.png',$size);
    }

    public function getImageData($image,$size){
      if(!$this->isCached($image,$size))
        $this->buildCacheFor($image,$size);
      return $this->getCachedData($image,$size);
    }
    public function getFromPlik(Plik $file,$size){
      $cname = $file->getCacheName().'-'.$file->getNazwa();
      if(!$this->isCached($cname,$size)){
        $extMap = array(
          'image/jpeg' => 'jpg',
          'image/jpg' => 'jpg',
          'image/png' => 'png',
          'image/gif' => 'gif'
        );
        $ext = $extMap[$file->getMime()];
        $new_img = $this->getImageFromString($file->getData(),$size,$ext);
        ob_start();
        switch ($ext) {
          case 'jpeg': case 'jpg': imagejpeg($new_img, null, 85  ); break;
          case 'gif': imagegif($new_img, null ); break;
          case 'png': default: imagepng($new_img, null, 9  ); break;
        };
        $img_data = ob_get_contents();
        imagedestroy($new_img);
        ob_end_clean();
        $this->saveDataToCache($cname,$size,$img_data);
      } else {
        $img_data = $this->getCachedData($cname,$size);
      }
      return $img_data;
    }
    private function getImageFromString($imgdata,$size,$type){
        $img = imagecreatefromstring($imgdata);
        $width  = imagesx($img);
        $height = imagesy($img);
        $target_width  = 0;
        $target_height = 0;
        if($width > $height){
          $target_width = $size;
          $target_height = $size * $height / $width;
        } else {
          $target_height = $size;
          $target_width = $size * $width / $height;
        }
        if($type == 'png' || $type == 'gif')
          return $this->resizePng($img,$target_width,$target_height);
        return imagescale($img,$target_width,$target_height);
    }
    private function saveImageToCache($image,$size,$image_data){
      $insplited = explode('.',$image);
      $ext = strtolower($insplited[count($insplited)-1]);
      @mkdir($this->cacheDir.DIRECTORY_SEPARATOR.$size,0777,true);
      switch ($ext) {
        case 'jpeg': case 'jpg':
          imagejpeg($image_data, $this->cacheDir.DIRECTORY_SEPARATOR.$size.DIRECTORY_SEPARATOR.$image, 85  );
          break;
        case 'gif':
          imagegif($image_data, $this->cacheDir.DIRECTORY_SEPARATOR.$size.DIRECTORY_SEPARATOR.$image );
          break;
        case 'png': default:
          imagepng($image_data, $this->cacheDir.DIRECTORY_SEPARATOR.$size.DIRECTORY_SEPARATOR.$image, 9  );
          break;
      };
    }
    private function saveDataToCache($image,$size,$image_data){
      @mkdir($this->cacheDir.DIRECTORY_SEPARATOR.$size,0777,true);
      file_put_contents($this->cacheDir.DIRECTORY_SEPARATOR.$size.DIRECTORY_SEPARATOR.$image,$image_data);
    }
    private function isCached($image,$size){
      return file_exists($this->cacheDir.DIRECTORY_SEPARATOR.$size.DIRECTORY_SEPARATOR.$image);
    }
    private function getCachedData($image,$size){
      return file_get_contents($this->cacheDir.DIRECTORY_SEPARATOR.$size.DIRECTORY_SEPARATOR.$image);
    }
    private function buildCacheFor($image,$size){
      $image_file = $this->fileLocator->locate('@kisRegBundle/Resources/image_base/'.$image);
      $insplited = explode('.',$image);
      $ext = strtolower($insplited[count($insplited)-1]);
      $new_img = $this->getImageFromString(file_get_contents($image_file),$size,$ext);
      $this->saveImageToCache($image,$size,$new_img);
      imagedestroy($new_img);
    }
    private function resizePng($im, $dst_width, $dst_height) {
        $width = imagesx($im);
        $height = imagesy($im);
        $newImg = imagecreatetruecolor($dst_width, $dst_height);
        imagealphablending($newImg, false);
        imagesavealpha($newImg, true);
        $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
        imagefilledrectangle($newImg, 0, 0, $width, $height, $transparent);
        imagecopyresampled($newImg, $im, 0, 0, 0, 0, $dst_width, $dst_height, $width, $height);

        return $newImg;
    }
}
