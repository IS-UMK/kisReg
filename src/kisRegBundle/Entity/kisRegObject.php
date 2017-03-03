<?php
namespace kisRegBundle\Entity;

interface kisRegObject {
    public function getThumb();
    public function __toString();
    public function getName();
    public function getDesc();
    public function getShortDesc();
    public function getLinked();
    public function getObjectType();
    public function getAbsoluteTime();
}
