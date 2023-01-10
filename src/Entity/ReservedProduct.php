<?php

namespace App\Entity;

use App\Repository\ReservedProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservedProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ReservedProduct
{
    const STATUS_RESERVED = 'reserved';
    const STATUS_BOUGHT = 'bought';
    const STATUS_CANCELED = 'canceled';


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantityReserved = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantityBuy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'reservedProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'reservedProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductParty $productParty = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantityReserved(): ?int
    {
        return $this->quantityReserved;
    }

    public function setQuantityReserved(int $quantityReserved): self
    {
        $this->quantityReserved = $quantityReserved;

        return $this;
    }

    public function getQuantityBuy(): ?int
    {
        return $this->quantityBuy;
    }

    public function setQuantityBuy(?int $quantityBuy): self
    {
        $this->quantityBuy = $quantityBuy;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProductParty(): ?ProductParty
    {
        return $this->productParty;
    }

    public function setProductParty(?ProductParty $productParty): self
    {
        $this->productParty = $productParty;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

}
