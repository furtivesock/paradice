<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoryPlayerRepository")
 */
class StoryPlayer
{
    /**
     * @var Story
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Story", inversedBy="storyPlayers")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $story;

    /**
     * @var Persona
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Persona", inversedBy="storyPlayers")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $player;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $acceptationDate;

    public function getStory(): ?Story
    {
        return $this->story;
    }

    public function setStory(?Story $story): self
    {
        $this->story = $story;

        return $this;
    }

    public function getPlayer(): ?Persona
    {
        return $this->player;
    }

    public function setPlayer(?Persona $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getAcceptationDate(): ?\DateTimeInterface
    {
        return $this->acceptationDate;
    }

    public function setAcceptationDate(\DateTimeInterface $acceptationDate): self
    {
        $this->acceptationDate = $acceptationDate;

        return $this;
    }
}
