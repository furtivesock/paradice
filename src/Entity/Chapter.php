<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChapterRepository")
 */
class Chapter
{
    /**
     * @var int
     * 
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message="Un nom doit être donné à votre chapitre !"
     * )
     */
    private $name;

    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @var bool
     * 
     * @ORM\Column(type="boolean")
     */
    private $end;

    /**
     * @var Location
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(
     *      message="Un lieu doit être donné à votre chapitre !"
     * )
     */
    private $location;

    /**
     * @var Story
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Story", inversedBy="chapters")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $story;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="chapter", orphanRemoval=true)
     */
    private $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getEnd(): ?bool
    {
        return $this->end;
    }

    public function setEnd(bool $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStory(): ?Story
    {
        return $this->story;
    }

    public function setStory(?Story $story): self
    {
        $this->story = $story;

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
            $message->setChapter($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getChapter() === $this) {
                $message->setChapter(null);
            }
        }

        return $this;
    }
}
