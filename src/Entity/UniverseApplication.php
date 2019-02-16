<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UniverseApplicationRepository")
 */
class UniverseApplication
{

    /**
     * @var int 
     * 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Universe", inversedBy="universeApplications")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $universe;

    /**
     * @var int 
     * 
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\OnlineUser", inversedBy="universeApplications")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $applicant;

    /**
     * @var string
     * 
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *      message="Votre demande devrait être motivée !"
     * )
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

    public function getUniverse(): ?Universe
    {
        return $this->universe;
    }

    public function setUniverse(?Universe $universe): self
    {
        $this->universe = $universe;

        return $this;
    }

    public function getApplicant(): ?OnlineUser
    {
        return $this->applicant;
    }

    public function setApplicant(?OnlineUser $applicant): self
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
