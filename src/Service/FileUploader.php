<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class FileUploader
{
    private $directories; 

    public function __construct($directories)
    {
        // directories list in config/services.yaml
        $this->directories = $directories;
    }

    public function upload(UploadedFile $file, $directory)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move($this->getDirectory($directory), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function removeFile($fileName, $directory){
        $completeFileName = $this->getDirectory($directory) . '/' . $fileName;
        $filesystem = new Filesystem();
        $filesystem->remove($completeFileName);
    }

    public function getDirectory($directory)
    {
        return $this->directories[$directory];
    }
}