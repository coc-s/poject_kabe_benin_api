<?php

namespace App\Entity;

use App\Entity\Photo;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ParrainageRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ParrainageRepository::class)
 */
class Parrainage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $nomEnfant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $prenomEnfant;

    /**
     * @ORM\Column(type="date", nullable=true)
     *@Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $dateNaissEnfant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     * 
     */
    private $sexe;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $dateParrainage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $ecole;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $village;

    /**
     * @ORM\ManyToOne(targetEntity=Photo::class)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $photo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEnfant(): ?string
    {
        return $this->nomEnfant;
    }

    public function setNomEnfant(?string $nomEnfant): self
    {
        $this->nomEnfant = $nomEnfant;

        return $this;
    }

    public function getPrenomEnfant(): ?string
    {
        return $this->prenomEnfant;
    }

    public function setPrenomEnfant(?string $prenomEnfant): self
    {
        $this->prenomEnfant = $prenomEnfant;

        return $this;
    }

    public function getDateNaissEnfant(): ?\DateTimeInterface
    {
        return $this->dateNaissEnfant;
    }

    public function setDateNaissEnfant(?\DateTimeInterface $dateNaissEnfant): self
    {
        $this->dateNaissEnfant = $dateNaissEnfant;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateParrainage(): ?\DateTimeInterface
    {
        return $this->dateParrainage;
    }

    public function setDateParrainage(?\DateTimeInterface $dateParrainage): self
    {
        $this->dateParrainage = $dateParrainage;

        return $this;
    }

    public function getEcole(): ?string
    {
        return $this->ecole;
    }

    public function setEcole(?string $ecole): self
    {
        $this->ecole = $ecole;

        return $this;
    }

    public function getVillage(): ?string
    {
        return $this->village;
    }

    public function setVillage(?string $village): self
    {
        $this->village = $village;

        return $this;
    }

    public function getPhoto(): ?Photo
    {
        return $this->photo;
    }

    public function setPhoto(?Photo $photo): self
    {
        $this->photo = $photo;

        return $this;
    }
}
