<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $trickImagesDirectory;
    private $userAvatarDirectory;

    public function __construct($trickImagesDirectory, $userAvatarDirectory)
    {
        $this->trickImagesDirectory = $trickImagesDirectory;
        $this->userAvatarDirectory = $userAvatarDirectory;
    }

    public function upload(UploadedFile $file, $directory)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            switch ($directory) {
                case 'trickImages':
                    $file->move($this->getTrickImagesDirectory(), $fileName);
                    break;
                
                case 'userAvatar':
                    $file->move($this->getUserAvatarDirectory(), $fileName);
                    break;
            }
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTrickImagesDirectory()
    {
        return $this->trickImagesDirectory;
    }

    public function getUserAvatarDirectory()
    {
        return $this->userAvatarDirectory;
    }
}