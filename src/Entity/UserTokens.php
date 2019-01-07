<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Users;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserTokensRepository")
 */
class UserTokens
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
    private $value;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateToken;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Users", inversedBy="userTokens", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct(Users $user, $type) {
        $now14j = new \DateTime();
        $now14j->add(new \DateInterval('P14D'));
        $this->setValue($this->newValue())
             ->setType($type)
             ->setDateToken($now14j)
             ->setUser($user);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    private function newValue()
    {
        $value = md5(uniqid());
        return $value;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateToken(): ?\DateTimeInterface
    {
        return $this->dateToken;
    }

    public function setDateToken(\DateTimeInterface $dateToken): self
    {
        $this->dateToken = $dateToken;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(Users $user): self
    {
        $this->user = $user;

        return $this;
    }

}
