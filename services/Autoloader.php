<?php

namespace app\services;

class Autoloader
{
    private $fileExtension = ".php";

    public function loadClass(string $className)
    {
        $className = str_replace(ROOT_NAMESPACE, ROOT_DIR, $className);
        $fileName = realpath($className . $this->fileExtension);
        if (file_exists($fileName)) {
            include $fileName;
            return true;
        }

        return false;
    }
}
