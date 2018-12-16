<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickImageRepository")
 */
class TrickImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Image(maxSize="1024k", maxSizeMessage="Fichier trop lourd 1mo Maxi !")
     */
    private $link;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tricks", inversedBy="trickImages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

    public function getId(): ?int
    {
        return $this->id;
    }

    // change to accept file Object instead of only string
    // public function getLink(): ?string
    public function getLink()
    {
        return $this->link;
    }

    // change to accept file Object instead of only string
    // public function setLink(string $link): self
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    public function getTrick(): ?Tricks
    {
        return $this->trick;
    }

    public function setTrick(?Tricks $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
