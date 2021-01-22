<?php

namespace App\Entity;

use DateTime;
use App\Entity\User;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TennisMatchRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=TennisMatchRepository::class)
 */
class TennisMatch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private ?string $adress;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tennisMatches")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $organizer;

    /**
     * @ORM\Column(type="time")
     */
    private ?DateTimeInterface $startHour;

    /**
     * @ORM\Column(type="time")
     */
    private ?DateTimeInterface $endHour;

    /**
     * @ORM\Column(type="date")
     */
    private ?DateTime $eventDate;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="participationMatch")
     */
    private Collection $participent;

    public function __construct()
    {
        $this->participent = new ArrayCollection();
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

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

    public function getOrganizer(): ?User
    {
        return $this->organizer;
    }

    public function setOrganizer(?User $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getStartHour(): ?DateTimeInterface
    {
        return $this->startHour;
    }

    public function setStartHour(DateTimeInterface $startHour): self
    {
        $this->startHour = $startHour;

        return $this;
    }

    public function getEndHour(): ?DateTimeInterface
    {
        return $this->endHour;
    }

    public function setEndHour(DateTimeInterface $endHour): self
    {
        $this->endHour = $endHour;

        return $this;
    }

    public function getEventDate(): ?DateTime
    {
        return $this->eventDate;
    }

    public function setEventDate(DateTime $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getParticipent(): Collection
    {
        return $this->participent;
    }

    public function addParticipent(User $participent): self
    {
        if (!$this->participent->contains($participent)) {
            $this->participent[] = $participent;
            $participent->addParticipationMatch($this);
        }

        return $this;
    }

    public function removeParticipent(User $participent): self
    {
        if ($this->participent->removeElement($participent)) {
            $participent->removeParticipationMatch($this);
        }

        return $this;
    }
}
