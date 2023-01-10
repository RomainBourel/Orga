<?php

namespace App\Entity;

use App\Repository\PropositionDateRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PropositionDateRepository::class)]
#[ORM\HasLifecycleCallbacks]
class PropositionDate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $startingAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $endingAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberMaxParticipant = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'propositionDates')]
    #[ORM\JoinColumn(nullable: false, onDelete: "cascade")]
    private ?Party $party = null;

    #[ORM\OneToOne(inversedBy: 'finalDate', cascade: ['persist', 'remove'])]
    private ?Party $finalDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingAt(): ?\DateTimeImmutable
    {
        return $this->startingAt;
    }

    public function setStartingAt(?\DateTimeImmutable $startingAt): self
    {
        $this->startingAt = $startingAt;

        return $this;
    }

    public function getEndingAt(): ?\DateTimeImmutable
    {
        return $this->endingAt;
    }

    public function setEndingAt(?\DateTimeImmutable $endingAt): self
    {
        $this->endingAt = $endingAt;

        return $this;
    }

    public function getNumberMaxParticipant(): ?int
    {
        return $this->numberMaxParticipant;
    }

    public function setNumberMaxParticipant(?int $numberMaxParticipant): self
    {
        $this->numberMaxParticipant = $numberMaxParticipant;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTimeImmutable;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTimeImmutable;

        return $this;
    }

    public function getParty(): ?Party
    {
        return $this->party;
    }

    public function setParty(?Party $party): self
    {
        $this->party = $party;

        return $this;
    }

    public function getFinalDate(): ?Party
    {
        return $this->finalDate;
    }

    public function setFinalDate(?Party $finalDate): self
    {
        $this->finalDate = $finalDate;

        return $this;
    }
}
