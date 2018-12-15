<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickCommentRepository")
 */
class TrickComment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="trickComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userCreate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tricks", inversedBy="trickComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getUserCreate(): ?Users
    {
        return $this->userCreate;
    }

    public function setUserCreate(?Users $userCreate): self
    {
        $this->userCreate = $userCreate;

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
