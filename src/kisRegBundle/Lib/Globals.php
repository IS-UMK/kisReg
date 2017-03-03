<?php
namespace kisRegBundle\Lib;

class Globals
{
    protected static $uploadDir = null;
    public static function setFileStorageDir($dir){self::$uploadDir = $dir;}
    public static function getFileStorageDir(){return self::$uploadDir;}
    protected static $currentUser=null;
    public static function setCurrentUser($user){self::$currentUser = $user;}
    public static function getCurrentUser(){return self::$currentUser;}
}

?>
