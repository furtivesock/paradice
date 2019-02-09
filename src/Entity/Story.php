<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoryRepository")
 */
class Story
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endRegistrationDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OnlineUser", inversedBy="stories")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Visibility")
     * @ORM\JoinColumn(nullable=false)
     */
    private $visibility;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Status")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StoryPlayer", mappedBy="story", orphanRemoval=true)
     */
    private $storyPlayers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StoryApplication", mappedBy="story", orphanRemoval=true)
     */
    private $storyApplications;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $summary;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Universe", inversedBy="stories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $universe;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chapter", mappedBy="story", orphanRemoval=true)
     */
    private $chapters;

    public function __construct()
    {
        $this->storyPlayers = new ArrayCollection();
        $this->storyApplications = new ArrayCollection();
        $this->chapters = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getName() : ? string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription() : ? string
    {
        return $this->description;
    }

    public function setDescription(? string $description) : self
    {
        $this->description = $description;

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

    public function getStartDate() : ? \DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(? \DateTimeInterface $startDate) : self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndRegistrationDate() : ? \DateTimeInterface
    {
        return $this->endRegistrationDate;
    }

    public function setEndRegistrationDate(? \DateTimeInterface $endRegistrationDate) : self
    {
        $this->endRegistrationDate = $endRegistrationDate;

        return $this;
    }


    public function getVisibility() : ? Visibility
    {
        return $this->visibility;
    }

    public function setVisibility(? Visibility $visibility) : self
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getStatus() : ? Status
    {
        return $this->status;
    }

    public function setStatus(? Status $status) : self
    {
        $this->status = $status;

        return $this;
    }


    /**
     * @return Collection|StoryPlayer[]
     */
    public function getStoryPlayers() : Collection
    {
        return $this->storyPlayers;
    }

    public function addStoryPlayer(StoryPlayer $storyPlayer) : self
    {
        if (!$this->storyPlayers->contains($storyPlayer)) {
            $this->storyPlayers[] = $storyPlayer;
            $storyPlayer->setStory($this);
        }

        return $this;
    }

    public function removeStoryPlayer(StoryPlayer $storyPlayer) : self
    {
        if ($this->storyPlayers->contains($storyPlayer)) {
            $this->storyPlayers->removeElement($storyPlayer);
            // set the owning side to null (unless already changed)
            if ($storyPlayer->getStory() === $this) {
                $storyPlayer->setStory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StoryApplication[]
     */
    public function getStoryApplications() : Collection
    {
        return $this->storyApplications;
    }

    public function addStoryApplication(StoryApplication $storyApplication) : self
    {
        if (!$this->storyApplications->contains($storyApplication)) {
            $this->storyApplications[] = $storyApplication;
            $storyApplication->setStory($this);
        }

        return $this;
    }

    public function removeStoryApplication(StoryApplication $storyApplication) : self
    {
        if ($this->storyApplications->contains($storyApplication)) {
            $this->storyApplications->removeElement($storyApplication);
            // set the owning side to null (unless already changed)
            if ($storyApplication->getStory() === $this) {
                $storyApplication->setStory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Chapter[]
     */
    public function getChapters() : Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter) : self
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters[] = $chapter;
            $chapter->setStory($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter) : self
    {
        if ($this->chapters->contains($chapter)) {
            $this->chapters->removeElement($chapter);
            // set the owning side to null (unless already changed)
            if ($chapter->getStory() === $this) {
                $chapter->setStory(null);
            }
        }

        return $this;
    }

    public function getSummary() : ? string
    {
        return $this->summary;
    }

    public function setSummary(? string $summary) : self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getUniverse() : ? Universe
    {
        return $this->universe;
    }

    public function setUniverse(? Universe $universe) : self
    {
        $this->universe = $universe;

        return $this;
    }

    public function getAuthor() : ? OnlineUser
    {
        return $this->author;
    }

    public function setAuthor(? OnlineUser $author) : self
    {
        $this->author = $author;

        return $this;
    }

    public function isVisibleByUser(? OnlineUser $user) : bool
    {
        if (is_null($user)) {
            return strcmp($this->visibility->getName(), 'ALL') === 0;
        }

        switch ($this->visibility->getName()) {
            case 'ALL':
                return true;
            case 'STORY':
                return $this->isPlayer($user);
            case 'UNIVERSE':
                return $this->universe->isMember($user);
            default:
                return false;
        }
    }

    public function isPlayer(OnlineUser $user) : bool
    {
        return $this->storyPlayers->exists(function (int $key, StoryPlayer $sPlayer) use ($user) {
            return $sPlayer->getPlayer()->getUser()->getId() === $user->getId();
        });
    }

    public function getPersonaByUser(? OnlineUser $user) : ? Persona
    {
        if (is_null($user)) {
            return null;
        }

        foreach ($this->storyPlayers as $sPlayers) {
            if ($sPlayers->getPlayer()->getUser()->getId() === $user->getId()) {
                return $sPlayers->getPlayer();
            }
        }

        return null;
    }

    public function toJson() : array
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'creationDate' => $this->getCreationDate(),
            'startDate' => $this->getStartDate(),
            'endRegistrationDate' => $this->getEndRegistrationDate(),
            'summary' => $this->getSummary(),
            'universe' => $this->getUniverse()->getId(),
            'author' => $this->getAuthor()->getId(),
            'visibility' => $this->getVisibility()->getId(),
            'status' => $this->getStatus()->getId(),
            'chapters' => $this->getChapters()->map(function (Chapter $chapter) {
                return array(
                    'id' => $chapter->getId()
                );
            })->toArray(),
            'players' => $this->getStoryPlayers()->map(function (StoryPlayer $uStory) {
                return array(
                    'id' => $uStory->getPlayer()->getId(),
                    'acceptationDate' => $uStory->getAcceptationDate()
                );
            })->toArray(),
            'applications' => $this->getStoryApplications()->map(function (StoryApplication $sApplication) {
                return array(
                    'id' => $sApplication->getApplicant()->getId(),
                    'applicationDate' => $sApplication->getApplicationDate(),
                    'motivation' => $sApplication->getMotivation(),
                    'accepted' => $sApplication->getAccepted()
                );
            })->toArray(),
        );
    }
}
