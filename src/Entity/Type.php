<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 */
class Type
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="subtypes")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $parentType;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Universe", inversedBy="types")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $universe;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Characteristic", mappedBy="type", orphanRemoval=true)
     */
    private $characteristics;

    public function __construct()
    {
        $this->characteristics = new ArrayCollection();
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

    public function getParentType(): ?self
    {
        return $this->parentType;
    }

    public function setParentType(?self $parentType): self
    {
        $this->parentType = $parentType;

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
            $characteristic->setType($this);
        }

        return $this;
    }

    public function removeCharacteristic(Characteristic $characteristic): self
    {
        if ($this->characteristics->contains($characteristic)) {
            $this->characteristics->removeElement($characteristic);
            // set the owning side to null (unless already changed)
            if ($characteristic->getType() === $this) {
                $characteristic->setType(null);
            }
        }

        return $this;
    }
}
