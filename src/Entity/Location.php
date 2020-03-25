<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
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
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageURL;

    /**
     * @var Location
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="subLocations")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $parentLocation;

    /**
     * @var Universe
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Universe", inversedBy="locations")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $universe;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="parentLocation", orphanRemoval=true)
     */
    private $subLocations;

    public function __construct()
    {
        $this->subLocations = new ArrayCollection();
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

    public function getImageURL(): ?string
    {
        return $this->imageURL;
    }

    public function setImageURL(?string $imageURL): self
    {
        $this->imageURL = $imageURL;

        return $this;
    }

    public function getParentLocation(): ?self
    {
        return $this->parentLocation;
    }

    public function setParentLocation(?self $parentLocation): self
    {
        $this->parentLocation = $parentLocation;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSubLocations(): Collection
    {
        return $this->subLocations;
    }

    public function addSubLocation(self $subLocation): self
    {
        if (!$this->subLocations->contains($subLocation)) {
            $this->subLocations[] = $subLocation;
            $subLocation->setParentLocation($this);
        }

        return $this;
    }

    public function removeSubLocation(self $subLocation): self
    {
        if ($this->subLocations->contains($subLocation)) {
            $this->subLocations->removeElement($subLocation);
            // set the owning side to null (unless already changed)
            if ($subLocation->getParentLocation() === $this) {
                $subLocation->setParentLocation(null);
            }
        }

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
}
