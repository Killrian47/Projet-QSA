<?php

namespace App\Entity;

use App\Repository\EnchantillonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnchantillonRepository::class)]
class Enchantillon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'enchantillons')]
    private ?Entreprise $entreprise = null;

    #[ORM\ManyToOne(inversedBy: 'enchantillons')]
    private ?Order $NumberOfOrder = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $productName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $numberOfBatch = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $supplier = null;

    #[ORM\Column(nullable: true)]
    private ?int $temperatureOfProduct = null;

    #[ORM\Column(nullable: true)]
    private ?int $temperatureOfEnceinte = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfManufacturing = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DlcOrDluo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfSampling = null;

    #[ORM\ManyToOne(inversedBy: 'enchantillons')]
    private ?Conditionnement $conditioning = null;

    #[ORM\ManyToOne(inversedBy: 'enchantillons')]
    private ?EtatPhysique $etatPhysique = null;

    #[ORM\ManyToOne(inversedBy: 'enchantillons')]
    private ?Lieu $Lieu = null;

    #[ORM\ManyToOne(inversedBy: 'enchantillons')]
    private ?Stockage $stockage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $analyseDlc = null;

    #[ORM\Column(nullable: true)]
    private ?bool $validationDlc = null;

    #[ORM\ManyToOne(inversedBy: 'enchantillons')]
    private ?Analyse $analyse = null;

    #[ORM\ManyToOne(inversedBy: 'enchantillons')]
    private ?Entreprise $samplingBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getNumberOfOrder(): ?Order
    {
        return $this->NumberOfOrder;
    }

    public function setNumberOfOrder(?Order $NumberOfOrder): self
    {
        $this->NumberOfOrder = $NumberOfOrder;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getNumberOfBatch(): ?string
    {
        return $this->numberOfBatch;
    }

    public function setNumberOfBatch(?string $numberOfBatch): self
    {
        $this->numberOfBatch = $numberOfBatch;

        return $this;
    }

    public function getSupplier(): ?string
    {
        return $this->supplier;
    }

    public function setSupplier(?string $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
    }

    public function getTemperatureOfProduct(): ?int
    {
        return $this->temperatureOfProduct;
    }

    public function setTemperatureOfProduct(?int $temperatureOfProduct): self
    {
        $this->temperatureOfProduct = $temperatureOfProduct;

        return $this;
    }

    public function getTemperatureOfEnceinte(): ?int
    {
        return $this->temperatureOfEnceinte;
    }

    public function setTemperatureOfEnceinte(?int $temperatureOfEnceinte): self
    {
        $this->temperatureOfEnceinte = $temperatureOfEnceinte;

        return $this;
    }

    public function getDateOfManufacturing(): ?\DateTimeInterface
    {
        return $this->dateOfManufacturing;
    }

    public function setDateOfManufacturing(?\DateTimeInterface $dateOfManufacturing): self
    {
        $this->dateOfManufacturing = $dateOfManufacturing;

        return $this;
    }

    public function getDlcOrDluo(): ?\DateTimeInterface
    {
        return $this->DlcOrDluo;
    }

    public function setDlcOrDluo(?\DateTimeInterface $DlcOrDluo): self
    {
        $this->DlcOrDluo = $DlcOrDluo;

        return $this;
    }

    public function getDateOfSampling(): ?\DateTimeInterface
    {
        return $this->dateOfSampling;
    }

    public function setDateOfSampling(?\DateTimeInterface $dateOfSampling): self
    {
        $this->dateOfSampling = $dateOfSampling;

        return $this;
    }

    public function getConditioning(): ?Conditionnement
    {
        return $this->conditioning;
    }

    public function setConditioning(?Conditionnement $conditioning): self
    {
        $this->conditioning = $conditioning;

        return $this;
    }

    public function getEtatPhysique(): ?EtatPhysique
    {
        return $this->etatPhysique;
    }

    public function setEtatPhysique(?EtatPhysique $etatPhysique): self
    {
        $this->etatPhysique = $etatPhysique;

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->Lieu;
    }

    public function setLieu(?Lieu $Lieu): self
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function getStockage(): ?Stockage
    {
        return $this->stockage;
    }

    public function setStockage(?Stockage $stockage): self
    {
        $this->stockage = $stockage;

        return $this;
    }

    public function isAnalyseDlc(): ?bool
    {
        return $this->analyseDlc;
    }

    public function setAnalyseDlc(?bool $analyseDlc): self
    {
        $this->analyseDlc = $analyseDlc;

        return $this;
    }

    public function isValidationDlc(): ?bool
    {
        return $this->validationDlc;
    }

    public function setValidationDlc(?bool $validationDlc): self
    {
        $this->validationDlc = $validationDlc;

        return $this;
    }

    public function getAnalyse(): ?Analyse
    {
        return $this->analyse;
    }

    public function setAnalyse(?Analyse $analyse): self
    {
        $this->analyse = $analyse;

        return $this;
    }

    public function getSamplingBy(): ?Entreprise
    {
        return $this->samplingBy;
    }

    public function setSamplingBy(?Entreprise $samplingBy): self
    {
        $this->samplingBy = $samplingBy;

        return $this;
    }
}
