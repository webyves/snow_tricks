<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\TrickImage;
use App\Service\TrickImageFileUploader;

class TrickImageUploadListener
{
    private $uploader;

    public function __construct(TrickImageFileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof TrickImage) {
            return;
        }

        if ($fileName = $entity->getLink()) {
            $entity->setLink($this->uploader->getTargetDirectory().'/'.$fileName);
            $this->removeFile($entity);
        }
    }

    private function uploadFile($entity)
    {
        // upload only works for TrickImage entities
        if (!$entity instanceof TrickImage) {
            return;
        }

        $file = $entity->getLink();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setLink($fileName);
        } elseif ($file instanceof File) {
            // prevents the full file path being saved on updates
            // as the path is set on the postLoad listener
            $entity->setLink($file->getFilename());
        }
    }

    private function removeFile($entity)
    {
        if (!$entity instanceof TrickImage) {
            return;
        }

        $filename = $entity->getLink();
        $filesystem = new Filesystem();
        $filesystem->remove($filename);
        
    }
}