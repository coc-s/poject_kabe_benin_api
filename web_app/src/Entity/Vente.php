<?php

namespace App\Entity;

use App\Entity\Produit;
use App\Entity\Evenement;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VenteRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VenteRepository::class)
 */
class Vente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $evenement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

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
