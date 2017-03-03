<?php

namespace kisRegBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use kisRegBundle\Lib\Globals;

class kisRegBundle extends Bundle
{
    public function boot()
    {
        Globals::setFileStorageDir($this->container->getParameter('kisReg.file_storage_path'));
    }
}
