<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParrainageRepository::class)
 */
class Parrainage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomEnfant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomEnfant;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateNaissEnfant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateParrainage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ecole;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $village;


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


    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}