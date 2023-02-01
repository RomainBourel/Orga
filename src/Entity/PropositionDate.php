<?php

namespace App\Entity;

use App\Repository\PropositionDateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    #[Assert\GreaterThan('today')]
    private ?\DateTimeImmutable $startingAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThan(propertyPath: "startingAt")]
    private ?\DateTimeImmutable $endingAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Positive]
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

    #[ORM\OneToMany(mappedBy: 'propositionDate', targetEntity: Available::class, orphanRemoval: true)]
    private Collection $availables;

    public function __construct()
    {
        $this->availables = new ArrayCollection();
    }

    public function __toString(): string
    {
        if ($this->startingAt && $this->endingAt) {
            return $this->startingAt->format('d/m/Y H:i') . ' - ' . $this->endingAt->format('d/m/Y H:i');
        }
        return $this->startingAt->format('d/m/Y H:i');
    }

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

    /**
     * @return Collection<int, Available>
     */
    public function getAvailables(): Collection
    {
        return $this->availables;
    }

    public function addAvailable(Available $available): self
    {
        if (!$this->availables->contains($available)) {
            $this->availables->add($available);
            $available->setPropositionDate($this);
        }

        return $this;
    }

    public function removeAvailable(Available $available): self
    {
        if ($this->availables->removeElement($available)) {
            // set the owning side to null (unless already changed)
            if ($available->getPropositionDate() === $this) {
                $available->setPropositionDate(null);
            }
        }

        return $this;
    }

    public function isUserAvailable(User $user): bool
    {
        return $this->availables->reduce(function(bool $accumulator, Available $value) use ($user) : bool {
            return $accumulator || ($value->getUser() === $user && $value->isAvailable());
        }, false);
    }

    public function isUserRefused(User $user): bool
    {
        return $this->availables->reduce(function(bool $accumulator, Available $value) use ($user) : bool {
            return $accumulator || ($value->getUser() === $user && !$value->isAvailable());
        }, false);
    }
}
