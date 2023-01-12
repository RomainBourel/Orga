<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $udatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Unity $unity = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductParty::class, orphanRemoval: true)]
    private Collection $productParties;

    #[ORM\Column(nullable: true)]
    private ?bool $isModerate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isPublished = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'reportedProducts')]
    private Collection $reporters;

    public function __construct()
    {
        $this->productParties = new ArrayCollection();
        $this->reporters = new ArrayCollection();
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

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

    public function getUdatedAt(): ?\DateTimeImmutable
    {
        return $this->udatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUdatedAt(): self
    {
        $this->udatedAt = new \DateTimeImmutable;

        return $this;
    }

    public function getUnity(): ?Unity
    {
        return $this->unity;
    }

    public function setUnity(?Unity $unity): self
    {
        $this->unity = $unity;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, ProductParty>
     */
    public function getProductParties(): Collection
    {
        return $this->productParties;
    }

    public function addProductParty(ProductParty $productParty): self
    {
        if (!$this->productParties->contains($productParty)) {
            $this->productParties->add($productParty);
            $productParty->setProduct($this);
        }

        return $this;
    }

    public function removeProductParty(ProductParty $productParty): self
    {
        if ($this->productParties->removeElement($productParty)) {
            // set the owning side to null (unless already changed)
            if ($productParty->getProduct() === $this) {
                $productParty->setProduct(null);
            }
        }

        return $this;
    }

    public function isIsModerate(): ?bool
    {
        return $this->isModerate;
    }

    public function setIsModerate(?bool $isModerate): self
    {
        $this->isModerate = $isModerate;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getReporters(): Collection
    {
        return $this->reporters;
    }

    public function addReporter(User $reporter): self
    {
        if (!$this->reporters->contains($reporter)) {
            $this->reporters->add($reporter);
        }

        return $this;
    }

    public function removeReporter(User $reporter): self
    {
        $this->reporters->removeElement($reporter);

        return $this;
    }
}
