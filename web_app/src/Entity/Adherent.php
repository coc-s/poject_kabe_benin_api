<?php

namespace App\Entity;

use App\Entity\Don;
use App\Entity\Evenement;
use App\Entity\Parrainage;
use App\Entity\Utilisateur;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdherentRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AdherentRepository::class)
 */
class Adherent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Parrainage::class)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $parrainage;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $evenement;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Don::class)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $don;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParrainage(): ?Parrainage
    {
        return $this->parrainage;
    }

    public function setParrainage(?Parrainage $parrainage)
    {
        $this->parrainage = $parrainage;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement)
    {
        $this->evenement = $evenement;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getDon(): ?Don
    {
        return $this->don;
    }

    public function setDon(?Don $don)
    {
        $this->don = $don;

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
