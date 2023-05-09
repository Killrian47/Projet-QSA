<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?bool $first_connection = null;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Analyse::class)]
    private Collection $analyses;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Pdf::class)]
    private Collection $pdfs;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Enchantillon::class)]
    private Collection $enchantillons;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->analyses = new ArrayCollection();
        $this->pdfs = new ArrayCollection();
        $this->enchantillons = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isFirstConnection(): ?bool
    {
        return $this->first_connection;
    }

    public function setFirstConnection(?bool $first_connection): self
    {
        $this->first_connection = $first_connection;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setEntreprise($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getEntreprise() === $this) {
                $order->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Analyse>
     */
    public function getAnalyses(): Collection
    {
        return $this->analyses;
    }

    public function addAnalysis(Analyse $analysis): self
    {
        if (!$this->analyses->contains($analysis)) {
            $this->analyses->add($analysis);
            $analysis->setEntreprise($this);
        }

        return $this;
    }

    public function removeAnalysis(Analyse $analysis): self
    {
        if ($this->analyses->removeElement($analysis)) {
            // set the owning side to null (unless already changed)
            if ($analysis->getEntreprise() === $this) {
                $analysis->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pdf>
     */
    public function getPdfs(): Collection
    {
        return $this->pdfs;
    }

    public function addPdf(Pdf $pdf): self
    {
        if (!$this->pdfs->contains($pdf)) {
            $this->pdfs->add($pdf);
            $pdf->setEntreprise($this);
        }

        return $this;
    }

    public function removePdf(Pdf $pdf): self
    {
        if ($this->pdfs->removeElement($pdf)) {
            // set the owning side to null (unless already changed)
            if ($pdf->getEntreprise() === $this) {
                $pdf->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Enchantillon>
     */
    public function getEnchantillons(): Collection
    {
        return $this->enchantillons;
    }

    public function addEnchantillon(Enchantillon $enchantillon): self
    {
        if (!$this->enchantillons->contains($enchantillon)) {
            $this->enchantillons->add($enchantillon);
            $enchantillon->setEntreprise($this);
        }

        return $this;
    }

    public function removeEnchantillon(Enchantillon $enchantillon): self
    {
        if ($this->enchantillons->removeElement($enchantillon)) {
            // set the owning side to null (unless already changed)
            if ($enchantillon->getEntreprise() === $this) {
                $enchantillon->setEntreprise(null);
            }
        }

        return $this;
    }
}
