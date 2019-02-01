<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UniverseRepository")
 */
class Universe
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
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OnlineUser")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $creator;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\OnlineUser", inversedBy="moderatedUniverses")
     */
    private $moderators;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UniverseMember", mappedBy="universe", orphanRemoval=true)
     */
    private $universeMembers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UniverseApplication", mappedBy="universe", orphanRemoval=true)
     */
    private $universeApplications;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoURL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bannerURL;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Story", mappedBy="universe", orphanRemoval=true)
     */
    private $stories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Type", mappedBy="universe", orphanRemoval=true)
     */
    private $types;


    public function __construct()
    {
        $this->moderators = new ArrayCollection();
        $this->universeMembers = new ArrayCollection();
        $this->universeApplications = new ArrayCollection();
        $this->stories = new ArrayCollection();
        $this->types = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getCreator(): ?OnlineUser
    {
        return $this->creator;
    }

    public function setCreator(?OnlineUser $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection|OnlineUser[]
     */
    public function getModerators(): Collection
    {
        return $this->moderators;
    }

    public function addModerator(OnlineUser $moderator): self
    {
        if (!$this->moderators->contains($moderator)) {
            $this->moderators[] = $moderator;
        }

        return $this;
    }

    public function removeModerator(OnlineUser $moderator): self
    {
        if ($this->moderators->contains($moderator)) {
            $this->moderators->removeElement($moderator);
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
            $universeMember->setUniverse($this);
        }

        return $this;
    }

    public function removeUniverseMember(UniverseMember $universeMember): self
    {
        if ($this->universeMembers->contains($universeMember)) {
            $this->universeMembers->removeElement($universeMember);
            // set the owning side to null (unless already changed)
            if ($universeMember->getUniverse() === $this) {
                $universeMember->setUniverse(null);
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
            $universeApplication->setUniverse($this);
        }

        return $this;
    }

    public function removeUniverseApplication(UniverseApplication $universeApplication): self
    {
        if ($this->universeApplications->contains($universeApplication)) {
            $this->universeApplications->removeElement($universeApplication);
            // set the owning side to null (unless already changed)
            if ($universeApplication->getUniverse() === $this) {
                $universeApplication->setUniverse(null);
            }
        }

        return $this;
    }

    public function getLogoURL(): ?string
    {
        return $this->LogoURL;
    }

    public function setLogoURL(?string $LogoURL): self
    {
        $this->LogoURL = $LogoURL;

        return $this;
    }

    public function getBannerURL(): ?string
    {
        return $this->BannerURL;
    }

    public function setBannerURL(?string $BannerURL): self
    {
        $this->BannerURL = $BannerURL;

        return $this;
    }

    /**
     * @return Collection|Story[]
     */
    public function getStories(): Collection
    {
        return $this->stories;
    }

    public function addStory(Story $story): self
    {
        if (!$this->stories->contains($story)) {
            $this->stories[] = $story;
            $story->setUniverse($this);
        }

        return $this;
    }

    public function removeStory(Story $story): self
    {
        if ($this->stories->contains($story)) {
            $this->stories->removeElement($story);
            // set the owning side to null (unless already changed)
            if ($story->getUniverse() === $this) {
                $story->setUniverse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Type[]
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
            $type->setUniverse($this);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->types->contains($type)) {
            $this->types->removeElement($type);
            // set the owning side to null (unless already changed)
            if ($type->getUniverse() === $this) {
                $type->setUniverse(null);
            }
        }

        return $this;
    }

   
}
