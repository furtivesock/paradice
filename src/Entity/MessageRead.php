<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageReadRepository")
 */
class MessageRead
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\OnlineUser", inversedBy="messagesRead")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Message", inversedBy="messagesRead")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $message;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $seen;

    public function getSeen(): ?bool
    {
        return $this->seen;
    }

    public function setSeen(bool $seen): self
    {
        $this->seen = $seen;

        return $this;
    }

    public function getUser(): ?OnlineUser
    {
        return $this->user;
    }

    public function setUser(?OnlineUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        return $this;
    }
}
