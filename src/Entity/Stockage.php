<?php

namespace App\Entity;

use App\Repository\StockageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockageRepository::class)]
class Stockage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'stockage', targetEntity: Enchantillon::class)]
    private Collection $enchantillons;

    public function __construct()
    {
        $this->enchantillons = new ArrayCollection();
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
            $enchantillon->setStockage($this);
        }

        return $this;
    }

    public function removeEnchantillon(Enchantillon $enchantillon): self
    {
        if ($this->enchantillons->removeElement($enchantillon)) {
            // set the owning side to null (unless already changed)
            if ($enchantillon->getStockage() === $this) {
                $enchantillon->setStockage(null);
            }
        }

        return $this;
    }
}
