<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoryApplicationRepository")
 */
class StoryApplication
{
    /**
     * @var Story
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Story", inversedBy="storyApplications")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $story;

    /**
     * @var Persona
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Persona", inversedBy="storyApplications")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $applicant;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $motivation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $applicationDate;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $accepted;

    public function getStory(): ?Story
    {
        return $this->story;
    }

    public function setStory(?Story $story): self
    {
        $this->story = $story;

        return $this;
    }

    public function getApplicant(): ?Persona
    {
        return $this->applicant;
    }

    public function setApplicant(?Persona $applicant): self
    {
        $this->applicant = $applicant;

        return $this;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): self
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getApplicationDate(): ?\DateTimeInterface
    {
        return $this->applicationDate;
    }

    public function setApplicationDate(\DateTimeInterface $applicationDate): self
    {
        $this->applicationDate = $applicationDate;

        return $this;
    }

    public function getAccepted(): ?bool
    {
        return $this->accepted;
    }

    public function setAccepted(?bool $accepted): self
    {
        $this->accepted = $accepted;

        return $this;
    }
}
