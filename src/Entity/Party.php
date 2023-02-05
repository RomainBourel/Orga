<?php

namespace App\Entity;

use App\Repository\PartyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Security;

#[ORM\Entity(repositoryClass: PartyRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Party
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'createdParties')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'parties')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'parties')]
    #[Assert\NotBlank]
    private ?Location $location = null;

    #[ORM\OneToMany(mappedBy: 'party', targetEntity: ProductParty::class, cascade:["persist", "remove"], orphanRemoval: true )]
    #[Assert\Valid]
    private Collection $productsParty;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $invitationToken = null;

    #[ORM\OneToMany(mappedBy: 'party', targetEntity: PropositionDate::class, cascade:["persist", "remove"], orphanRemoval: true)]
    #[Assert\Count(min:1, minMessage: 'party.proposition_date')]
    #[Assert\Valid]
    private Collection $propositionDates;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->productsParty = new ArrayCollection();
        $this->propositionDates = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTimeImmutable();

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
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;
        $this->addUser($creator);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, ProductParty>
     */
    public function getProductsParty(): Collection
    {
        return $this->productsParty;
    }

    public function addProductsParty(ProductParty $productsParty): self
    {
        if (!$this->productsParty->contains($productsParty)) {
            $this->productsParty->add($productsParty);
            $productsParty->setParty($this);
        }

        return $this;
    }

    public function removeProductsParty(ProductParty $productsParty): self
    {
        if ($this->productsParty->removeElement($productsParty)) {
            // set the owning side to null (unless already changed)
            if ($productsParty->getParty() === $this) {
                $productsParty->setParty(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getInvitationToken(): ?string
    {
        return $this->invitationToken;
    }

    public function setInvitationToken(?string $invitationToken): self
    {
        $this->invitationToken = $invitationToken;

        return $this;
    }

    /**
     * @return Collection<int, PropositionDate>
     */
    public function getPropositionDates(): Collection
    {
        return $this->propositionDates;
    }

    public function addPropositionDate(PropositionDate $propositionDate): self
    {
        if (!$this->propositionDates->contains($propositionDate)) {
            $this->propositionDates->add($propositionDate);
            $propositionDate->setParty($this);
        }

        return $this;
    }

    public function removePropositionDate(PropositionDate $propositionDate): self
    {
        if ($this->propositionDates->removeElement($propositionDate)) {
            // set the owning side to null (unless already changed)
            if ($propositionDate->getParty() === $this) {
                $propositionDate->setParty(null);
            }
        }

        return $this;
    }

    public function isFinalDate(): bool
    {
        return $this->propositionDates->exists(function($key, $propositionDate) {
                return $propositionDate->isValid();
            });
    }
    public function getFinalDate(): ?PropositionDate
    {
        $finalDate = $this->propositionDates->filter(function($propositionDate) {
            return $propositionDate->isFinalDate();
        })->first();
        return $finalDate ? $finalDate : null;
    }

    public function setFinalDate(?PropositionDate $propositionDate = null): self
    {
        if ($propositionDate === null) {
            $this->propositionDates->map(function($propositionDate) {
                $propositionDate->setFinalDate(null);
            });
            return $this;
        }
        $this->propositionDates->map(function($propositionDate) {
            $propositionDate->setFinalDate(false);
        });
        return $this->addPropositionDate($propositionDate->setFinalDate(true));
    }

}
