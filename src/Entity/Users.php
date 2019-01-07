<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @UniqueEntity(fields={"email"}, message="L'email est deja utilisé")
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message = "cet email '{{ value }}' est invalide.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="6", minMessage = "Votre message doit faire au moins 6 caracteres")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tricks", mappedBy="userCreate")
     */
    private $userCreate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tricks", mappedBy="userUpdate")
     */
    private $userUpdate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrickComment", mappedBy="userCreate", orphanRemoval=true)
     */
    private $trickComments;

    /**
    * @Assert\EqualTo(propertyPath="password", message = "Votre mot de passe n'est pas identique à la confirmation")
    */
    public $confirmPassword;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserTokens", mappedBy="user", cascade={"persist", "remove"})
     */
    private $userTokens;

    /**
     * @ORM\Column(type="boolean")
     */
    private $valid;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->userCreate = new ArrayCollection();
        $this->userUpdate = new ArrayCollection();
        $this->trickComments = new ArrayCollection();
        
        $this->setDateInscription(new \DateTime())
             ->setValid(false);

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getAvatar(): ?string
    // public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    // public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Tricks[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Tricks $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setUserCreate($this);
        }

        return $this;
    }

    public function removeUser(Tricks $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUserCreate() === $this) {
                $user->setUserCreate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tricks[]
     */
    public function getUserCreate(): Collection
    {
        return $this->userCreate;
    }

    public function addUserCreate(Tricks $userCreate): self
    {
        if (!$this->userCreate->contains($userCreate)) {
            $this->userCreate[] = $userCreate;
            $userCreate->setUserCreate($this);
        }

        return $this;
    }

    public function removeUserCreate(Tricks $userCreate): self
    {
        if ($this->userCreate->contains($userCreate)) {
            $this->userCreate->removeElement($userCreate);
            // set the owning side to null (unless already changed)
            if ($userCreate->getUserCreate() === $this) {
                $userCreate->setUserCreate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tricks[]
     */
    public function getUserUpdate(): Collection
    {
        return $this->userUpdate;
    }

    public function addUserUpdate(Tricks $userUpdate): self
    {
        if (!$this->userUpdate->contains($userUpdate)) {
            $this->userUpdate[] = $userUpdate;
            $userUpdate->setUserUpdate($this);
        }

        return $this;
    }

    public function removeUserUpdate(Tricks $userUpdate): self
    {
        if ($this->userUpdate->contains($userUpdate)) {
            $this->userUpdate->removeElement($userUpdate);
            // set the owning side to null (unless already changed)
            if ($userUpdate->getUserUpdate() === $this) {
                $userUpdate->setUserUpdate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TrickComment[]
     */
    public function getTrickComments(): Collection
    {
        return $this->trickComments;
    }

    public function addTrickComment(TrickComment $trickComment): self
    {
        if (!$this->trickComments->contains($trickComment)) {
            $this->trickComments[] = $trickComment;
            $trickComment->setUserCreate($this);
        }

        return $this;
    }

    public function removeTrickComment(TrickComment $trickComment): self
    {
        if ($this->trickComments->contains($trickComment)) {
            $this->trickComments->removeElement($trickComment);
            // set the owning side to null (unless already changed)
            if ($trickComment->getUserCreate() === $this) {
                $trickComment->setUserCreate(null);
            }
        }

        return $this;
    }


    public function eraseCredentials() {}
    public function getSalt() {}

    public function getRoles() 
    {
        return ['ROLE_USER'];
    }

    public function getUsername() 
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getUserTokens(): ?UserTokens
    {
        return $this->userTokens;
    }

    public function setUserTokens(UserTokens $userTokens): self
    {
        $this->userTokens = $userTokens;

        // set the owning side of the relation if necessary
        if ($this !== $userTokens->getUser()) {
            $userTokens->setUser($this);
        }

        return $this;
    }

    public function getValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }
}
