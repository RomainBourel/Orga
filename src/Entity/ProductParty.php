<?php

namespace App\Entity;

use App\Repository\ProductPartyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductPartyRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ProductParty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $sharing = false;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'productParties')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'productsParty')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Party $party = null;

    #[ORM\OneToMany(mappedBy: 'productParty', targetEntity: ReservedProduct::class, orphanRemoval: true)]
    private Collection $reservedProducts;

    public function __construct()
    {
        $this->reservedProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isSharing(): ?bool
    {
        return $this->sharing;
    }

    public function setSharing(bool $sharing): self
    {
        $this->sharing = $sharing;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantityReserved(): int
    {
        $quantityReserved = 0;
        foreach ($this->reservedProducts as $reservedProduct) {
            $quantityReserved += $reservedProduct->getQuantityReserved();
        }
        return $quantityReserved;
    }

    public function getReservedProductByUser(User $user): ?ReservedProduct
    {
        foreach ($this->reservedProducts as $reservedProduct) {
            if ($reservedProduct->getUser() === $user) {
                return $reservedProduct;
            }
        }
        return null;
    }
    public function getQuantityBuy(): int
    {
        $quantityBuy = 0;
        foreach ($this->reservedProducts as $reservedProduct) {
            $quantityBuy += $reservedProduct->getQuantityBuy();
        }
        return $quantityBuy;
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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

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

    /**
     * @return Collection<int, ReservedProduct>
     */
    public function getReservedProducts(): Collection
    {
        return $this->reservedProducts;
    }

    public function addReservedProduct(ReservedProduct $reservedProduct): self
    {
        if (!$this->reservedProducts->contains($reservedProduct)) {
            $this->reservedProducts->add($reservedProduct);
            $reservedProduct->setProductParty($this);
        }

        return $this;
    }

    public function removeReservedProduct(ReservedProduct $reservedProduct): self
    {
        if ($this->reservedProducts->removeElement($reservedProduct)) {
            // set the owning side to null (unless already changed)
            if ($reservedProduct->getProductParty() === $this) {
                $reservedProduct->setProductParty(null);
            }
        }

        return $this;
    }
}
