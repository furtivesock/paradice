<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OnlineUserRepository")
 * @UniqueEntity("email", message="Cet email existe déjà")
 * @UniqueEntity("username", message="Ce nom d'utilisateur existe déjà")
 */
class OnlineUser implements UserInterface
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
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Le nom d'utilisateur est obligatoire")
     */
    private $username;

    /**
     * @var string[]
     * 
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * 
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(type="datetime")
     */
    private $creationDate;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $avatarURL;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="L'email est obligatoire")
     * @Assert\Email(message="L'email donné n'est pas valide")
     */
    private $email;

    /**
     * @var ArrayCollection
     * 
     * @ORM\ManyToMany(targetEntity="App\Entity\Universe", mappedBy="moderators")
     */
    private $moderatedUniverses;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\UniverseMember", mappedBy="member", orphanRemoval=true)
     */
    private $universeMembers;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\UniverseApplication", mappedBy="applicant", orphanRemoval=true)
     */
    private $universeApplications;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\MessageRead", mappedBy="user", orphanRemoval=true)
     */
    private $messagesRead;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Story", mappedBy="author")
     */
    private $stories;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Persona", mappedBy="user", orphanRemoval=true)
     */
    private $personas;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="sender")
     */
    private $messages;

    public function __construct()
    {
        $this->moderatedUniverses = new ArrayCollection();
        $this->universeMembers = new ArrayCollection();
        $this->universeApplications = new ArrayCollection();
        $this->messagesRead = new ArrayCollection();
        $this->stories = new ArrayCollection();
        $this->personas = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername() : string
    {
        return (string)$this->username;
    }

    public function setUsername(string $username) : self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles() : array
    {
        $roles = $this->roles;

        return array_unique($roles);
    }

    public function setRoles(array $roles) : self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword() : string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" or "argon2i" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getAvatarURL() : ? string
    {
        return $this->avatarURL;
    }

    public function setAvatarURL(? string $avatarURL) : self
    {
        $this->avatarURL = $avatarURL;

        return $this;
    }

    public function getEmail() : ? string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Universe[]
     */
    public function getModeratedUniverses() : Collection
    {
        return $this->moderatedUniverses;
    }

    public function addModeratedUniverse(Universe $moderatedUniverse) : self
    {
        if (!$this->moderatedUniverses->contains($moderatedUniverse)) {
            $this->moderatedUniverses[] = $moderatedUniverse;
            $moderatedUniverse->addModerator($this);
        }

        return $this;
    }

    public function removeModeratedUniverse(Universe $moderatedUniverse) : self
    {
        if ($this->moderatedUniverses->contains($moderatedUniverse)) {
            $this->moderatedUniverses->removeElement($moderatedUniverse);
            $moderatedUniverse->removeModerator($this);
        }

        return $this;
    }

    /**
     * @return Collection|UniverseMember[]
     */
    public function getUniverseMembers() : Collection
    {
        return $this->universeMembers;
    }

    public function addUniverseMember(UniverseMember $universeMember) : self
    {
        if (!$this->universeMembers->contains($universeMember)) {
            $this->universeMembers[] = $universeMember;
            $universeMember->setMember($this);
        }

        return $this;
    }

    public function removeUniverseMember(UniverseMember $universeMember) : self
    {
        if ($this->universeMembers->contains($universeMember)) {
            $this->universeMembers->removeElement($universeMember);
            // set the owning side to null (unless already changed)
            if ($universeMember->getMember() === $this) {
                $universeMember->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UniverseApplication[]
     */
    public function getUniverseApplications() : Collection
    {
        return $this->universeApplications;
    }

    public function addUniverseApplication(UniverseApplication $universeApplication) : self
    {
        if (!$this->universeApplications->contains($universeApplication)) {
            $this->universeApplications[] = $universeApplication;
            $universeApplication->setApplicant($this);
        }

        return $this;
    }

    public function removeUniverseApplication(UniverseApplication $universeApplication) : self
    {
        if ($this->universeApplications->contains($universeApplication)) {
            $this->universeApplications->removeElement($universeApplication);
            // set the owning side to null (unless already changed)
            if ($universeApplication->getApplicant() === $this) {
                $universeApplication->setApplicant(null);
            }
        }

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
            $messagesRead->setUser($this);
        }

        return $this;
    }

    public function removeMessagesRead(MessageRead $messagesRead) : self
    {
        if ($this->messagesRead->contains($messagesRead)) {
            $this->messagesRead->removeElement($messagesRead);
            // set the owning side to null (unless already changed)
            if ($messagesRead->getUser() === $this) {
                $messagesRead->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Story[]
     */
    public function getStories() : Collection
    {
        return $this->stories;
    }

    public function addStory(Story $story) : self
    {
        if (!$this->stories->contains($story)) {
            $this->stories[] = $story;
            $story->setAuthor($this);
        }

        return $this;
    }

    public function removeStory(Story $story) : self
    {
        if ($this->stories->contains($story)) {
            $this->stories->removeElement($story);
            // set the owning side to null (unless already changed)
            if ($story->getAuthor() === $this) {
                $story->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Persona[]
     */
    public function getPersonas() : Collection
    {
        return $this->personas;
    }

    public function addPersona(Persona $persona) : self
    {
        if (!$this->personas->contains($persona)) {
            $this->personas[] = $persona;
            $persona->setUser($this);
        }

        return $this;
    }

    public function removePersona(Persona $persona) : self
    {
        if ($this->personas->contains($persona)) {
            $this->personas->removeElement($persona);
            // set the owning side to null (unless already changed)
            if ($persona->getUser() === $this) {
                $persona->setUser(null);
            }
        }

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
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }
}
