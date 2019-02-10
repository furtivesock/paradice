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
     * @ORM\OneToMany(targetEntity="App\Entity\MessageRead", mappedBy="message", orphanRemoval=true)
     */
    private $messagesRead;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chapter", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $chapter;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OnlineUser", inversedBy="messages")
     */
    private $sender;

    public function __construct()
    {
        $this->messagesRead = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getContents() : ? string
    {
        return $this->contents;
    }

    public function setContents(string $contents) : self
    {
        $this->contents = $contents;

        return $this;
    }

    public function getCreationDate() : ? \DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate) : self
    {
        $this->creationDate = $creationDate;

        return $this;
    }


    /**
     * @return Collection|MessageRead[]
     */
    public function getMessagesRead() : Collection
    {
        return $this->messagesRead;
    }

    public function addMessagesRead(MessageRead $messagesRead) : self
    {
        if (!$this->messagesRead->contains($messagesRead)) {
            $this->messagesRead[] = $messagesRead;
            $messagesRead->setMessage($this);
        }

        return $this;
    }

    public function removeMessagesRead(MessageRead $messagesRead) : self
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

    public function getChapter() : ? Chapter
    {
        return $this->chapter;
    }

    public function setChapter(? Chapter $chapter) : self
    {
        $this->chapter = $chapter;

        return $this;
    }

    public function getSender() : ? OnlineUser
    {
        return $this->sender;
    }

    public function setSender(? OnlineUser $sender) : self
    {
        $this->sender = $sender;

        return $this;
    }

    public function toJson() : array
    {
        $story = $this->getChapter()->getStory();

        $message = array(
            'id' => $this->getId(),
            'contents' => $this->getContents(),
            'creationDate' => $this->getCreationDate()
        );

        if ($story->isAuthor($this->getSender())) {
            $message['sender'] = array(
                'is_author' => true,
                'name' => $this->getSender()->getUsername()
            );
        } else {
            $persona = $story->getPersonaByUser($this->getSender());
            $message['sender'] = array(
                'is_author' => false,
                'firstname' => $persona->getFirstName(), 
                'lastname' => $persona->getLastName(),
            );
        }

        return $message;
    }
}
