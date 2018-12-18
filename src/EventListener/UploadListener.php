<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\TrickImage;
use App\Entity\Users;
use App\Service\FileUploader;

class UploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        // retirer l'ancien avatar
        // if ($entity instanceof Users) {
        //     if ($fileName = $entity->getAvatar()) {
        //         $entity->setAvatar($this->uploader->getUserAvatarDirectory().'/'.$fileName);
        //         $this->removeFile($entity);
        //     }
        // }
        
        $this->uploadFile($entity);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof TrickImage) {
            if ($fileName = $entity->getLink()) {
                $entity->setLink($this->uploader->getTrickImagesDirectory().'/'.$fileName);
                $this->removeFile($entity);
            }
        }

    }

    private function uploadFile($entity)
    {
        if ($entity instanceof TrickImage) {
            $file = $entity->getLink();
            $fileName = $this->uploader->upload($file, "trickImages");
            $entity->setLink($fileName);
        // } elseif ($entity instanceof Users) {
        //     $file = $entity->getAvatar();
        //     $fileName = $this->uploader->upload($file, "userAvatar");
        //     $entity->setAvatar($fileName);
        }

    }

    private function removeFile($entity)
    {
        if ($entity instanceof TrickImage) {
            $filename = $entity->getLink();
        // } elseif ($entity instanceof Users) {
        //     $filename = $entity->getAvatar();
        } else {
            return;
        }

        $filesystem = new Filesystem();
        $filesystem->remove($filename);
        
    }
}