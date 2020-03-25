<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UniverseMemberRepository")
 */
class UniverseMember
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\OnlineUser", inversedBy="universeMembers")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $member;

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Universe", inversedBy="universeMembers")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $universe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $acceptationDate;

    public function getMember(): ?OnlineUser
    {
        return $this->member;
    }

    public function setMember(?OnlineUser $member): self
    {
        $this->member = $member;

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
