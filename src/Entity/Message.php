<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
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
    private $contents;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Persona")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chapter")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chapter;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MessageRead", mappedBy="message", orphanRemoval=true)
     */
    private $messagesRead;

    public function __construct()
    {
        $this->messagesRead = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContents(): ?string
    {
        return $this->contents;
    }

    public function setContents(string $contents): self
    {
        $this->contents = $contents;

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

    public function getSender(): ?Persona
    {
        return $this->sender;
    }

    public function setSender(?Persona $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getChapter(): ?Chapter
    {
        return $this->chapter;
    }

    public function setChapter(?Chapter $chapter): self
    {
        $this->chapter = $chapter;

        return $this;
    }

    /**
     * @return Collection|MessageRead[]
     */
    public function getMessagesRead(): Collection
    {
        return $this->messagesRead;
    }

    public function addMessagesRead(MessageRead $messagesRead): self
    {
        if (!$this->messagesRead->contains($messagesRead)) {
            $this->messagesRead[] = $messagesRead;
            $messagesRead->setMessage($this);
        }

        return $this;
    }

    public function removeMessagesRead(MessageRead $messagesRead): self
    {
        if ($this->messagesRead->contains($messagesRead)) {
            $this->messagesRead->removeElement($messagesRead);
            // set the owning side to null (unless already changed)
            if ($messagesRead->getMessage() === $this) {
                $messagesRead->setMessage(null);
            }
        }

        return $this;
    }
}
