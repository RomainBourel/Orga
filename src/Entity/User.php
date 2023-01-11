<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Party::class, orphanRemoval: true)]
    private Collection $createdParties;

    #[ORM\ManyToMany(targetEntity: Party::class, mappedBy: 'users')]
    private Collection $parties;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Location::class, orphanRemoval: true)]
    private Collection $locations;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Available::class, orphanRemoval: true)]
    private Collection $availables;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ReservedProduct::class)]
    private Collection $reservedProducts;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $username = null;

    public function __construct()
    {
        $this->createdParties = new ArrayCollection();
        $this->parties = new ArrayCollection();
        $this->locations = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->availables = new ArrayCollection();
        $this->reservedProducts = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Party>
     */
    public function getCreatedParties(): Collection
    {
        return $this->createdParties;
    }

    public function addCreatedParty(Party $createdParty): self
    {
        if (!$this->createdParties->contains($createdParty)) {
            $this->createdParties->add($createdParty);
            $createdParty->setCreator($this);
        }

        return $this;
    }

    public function removeCreatedParty(Party $createdParty): self
    {
        if ($this->createdParties->removeElement($createdParty)) {
            // set the owning side to null (unless already changed)
            if ($createdParty->getCreator() === $this) {
                $createdParty->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Party>
     */
    public function getParties(): Collection
    {
        return $this->parties;
    }

    public function addParty(Party $party): self
    {
        if (!$this->parties->contains($party)) {
            $this->parties->add($party);
            $party->addUser($this);
        }

        return $this;
    }

    public function removeParty(Party $party): self
    {
        if ($this->parties->removeElement($party)) {
            $party->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
            $location->setUser($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getUser() === $this) {
                $location->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setUser($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getUser() === $this) {
                $product->setUser(null);
            }
        }

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
            $available->setUser($this);
        }

        return $this;
    }

    public function removeAvailable(Available $available): self
    {
        if ($this->availables->removeElement($available)) {
            // set the owning side to null (unless already changed)
            if ($available->getUser() === $this) {
                $available->setUser(null);
            }
        }

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
            $reservedProduct->setUser($this);
        }

        return $this;
    }

    public function removeReservedProduct(ReservedProduct $reservedProduct): self
    {
        if ($this->reservedProducts->removeElement($reservedProduct)) {
            // set the owning side to null (unless already changed)
            if ($reservedProduct->getUser() === $this) {
                $reservedProduct->setUser(null);
            }
        }

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
}
