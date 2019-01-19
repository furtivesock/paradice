<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OnlineUserRepository")
 */
class OnlineUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatarURL;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Universe", mappedBy="moderators")
     */
    private $moderatedUniverses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UniverseMember", mappedBy="member", orphanRemoval=true)
     */
    private $universeMembers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UniverseApplication", mappedBy="applicant", orphanRemoval=true)
     */
    private $universeApplications;


    public function __construct()
    {
        $this->createdUniverses = new ArrayCollection();
        $this->messageSupports = new ArrayCollection();
        $this->stories = new ArrayCollection();
        $this->personas = new ArrayCollection();
        $this->universes = new ArrayCollection();
        $this->moderatedUniverses = new ArrayCollection();
        $this->universeMembers = new ArrayCollection();
        $this->universeApplications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getAvatarURL(): ?string
    {
        return $this->avatarURL;
    }

    public function setAvatarURL(?string $avatarURL): self
    {
        $this->avatarURL = $avatarURL;

        return $this;
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

    /**
     * @return Collection|Universe[]
     */
    public function getModeratedUniverses(): Collection
    {
        return $this->moderatedUniverses;
    }

    public function addModeratedUniverse(Universe $moderatedUniverse): self
    {
        if (!$this->moderatedUniverses->contains($moderatedUniverse)) {
            $this->moderatedUniverses[] = $moderatedUniverse;
            $moderatedUniverse->addModerator($this);
        }

        return $this;
    }

    public function removeModeratedUniverse(Universe $moderatedUniverse): self
    {
        if ($this->moderatedUniverses->contains($moderatedUniverse)) {
            $this->moderatedUniverses->removeElement($moderatedUniverse);
            $moderatedUniverse->removeModerator($this);
        }

        return $this;
    }

    /**
     * @return Collection|UniverseMember[]
     */
    public function getUniverseMembers(): Collection
    {
        return $this->universeMembers;
    }

    public function addUniverseMember(UniverseMember $universeMember): self
    {
        if (!$this->universeMembers->contains($universeMember)) {
            $this->universeMembers[] = $universeMember;
            $universeMember->setMember($this);
        }

        return $this;
    }

    public function removeUniverseMember(UniverseMember $universeMember): self
    {
        if ($this->universeMembers->contains($universeMember)) {
            $this->universeMembers->removeElement($universeMember);
            // set the owning side to null (unless already changed)
            if ($universeMember->getMember() === $this) {
                $universeMember->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UniverseApplication[]
     */
    public function getUniverseApplications(): Collection
    {
        return $this->universeApplications;
    }

    public function addUniverseApplication(UniverseApplication $universeApplication): self
    {
        if (!$this->universeApplications->contains($universeApplication)) {
            $this->universeApplications[] = $universeApplication;
            $universeApplication->setApplicant($this);
        }

        return $this;
    }

    public function removeUniverseApplication(UniverseApplication $universeApplication): self
    {
        if ($this->universeApplications->contains($universeApplication)) {
            $this->universeApplications->removeElement($universeApplication);
            // set the owning side to null (unless already changed)
            if ($universeApplication->getApplicant() === $this) {
                $universeApplication->setApplicant(null);
            }
        }

        return $this;
    }
}
