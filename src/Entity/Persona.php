<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonaRepository")
 */
class Persona
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $physicalDescription;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $personality;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $background;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatarURL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Universe")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $universe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OnlineUser", inversedBy="personas")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Characteristic")
     */
    private $characteristics;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StoryPlayer", mappedBy="player", orphanRemoval=true)
     */
    private $storyPlayers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StoryApplication", mappedBy="applicant", orphanRemoval=true)
     */
    private $storyApplications;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="sender")
     */
    private $messages;

    public function __construct()
    {
        $this->characteristics = new ArrayCollection();
        $this->storyPlayers = new ArrayCollection();
        $this->storyApplications = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPhysicalDescription(): ?string
    {
        return $this->physicalDescription;
    }

    public function setPhysicalDescription(?string $physicalDescription): self
    {
        $this->physicalDescription = $physicalDescription;

        return $this;
    }

    public function getPersonality(): ?string
    {
        return $this->personality;
    }

    public function setPersonality(?string $personality): self
    {
        $this->personality = $personality;

        return $this;
    }

    public function getBackground(): ?string
    {
        return $this->background;
    }

    public function setBackground(?string $background): self
    {
        $this->background = $background;

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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getUniverse(): ?Universe
    {
        return $this->universe;
    }

    public function setUniverse(?Universe $universe): self
    {
        $this->universe = $universe;

        return $this;
    }

    public function getUser(): ?OnlineUser
    {
        return $this->user;
    }

    public function setUser(?OnlineUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Characteristic[]
     */
    public function getCharacteristics(): Collection
    {
        return $this->characteristics;
    }

    public function addCharacteristic(Characteristic $characteristic): self
    {
        if (!$this->characteristics->contains($characteristic)) {
            $this->characteristics[] = $characteristic;
        }

        return $this;
    }

    public function removeCharacteristic(Characteristic $characteristic): self
    {
        if ($this->characteristics->contains($characteristic)) {
            $this->characteristics->removeElement($characteristic);
        }

        return $this;
    }

    /**
     * @return Collection|StoryPlayer[]
     */
    public function getStoryPlayers(): Collection
    {
        return $this->storyPlayers;
    }

    public function addStoryPlayer(StoryPlayer $storyPlayer): self
    {
        if (!$this->storyPlayers->contains($storyPlayer)) {
            $this->storyPlayers[] = $storyPlayer;
            $storyPlayer->setPlayer($this);
        }

        return $this;
    }

    public function removeStoryPlayer(StoryPlayer $storyPlayer): self
    {
        if ($this->storyPlayers->contains($storyPlayer)) {
            $this->storyPlayers->removeElement($storyPlayer);
            // set the owning side to null (unless already changed)
            if ($storyPlayer->getPlayer() === $this) {
                $storyPlayer->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StoryApplication[]
     */
    public function getStoryApplications(): Collection
    {
        return $this->storyApplications;
    }

    public function addStoryApplication(StoryApplication $storyApplication): self
    {
        if (!$this->storyApplications->contains($storyApplication)) {
            $this->storyApplications[] = $storyApplication;
            $storyApplication->setApplicant($this);
        }

        return $this;
    }

    public function removeStoryApplication(StoryApplication $storyApplication): self
    {
        if ($this->storyApplications->contains($storyApplication)) {
            $this->storyApplications->removeElement($storyApplication);
            // set the owning side to null (unless already changed)
            if ($storyApplication->getApplicant() === $this) {
                $storyApplication->setApplicant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }
}
