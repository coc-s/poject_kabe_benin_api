<?php

namespace App\Entity;

// use App\Entity\Photo;
// use App\Entity\Evenement;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
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
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $prix;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $quantite;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $disponibilite;

    // /**
    //  * @ORM\ManyToOne(targetEntity=Photo::class)
    //  * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
    //  */
    // private $photo;

    // /**
    //  * @ORM\ManyToOne(targetEntity=Evenement::class)
    //  * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
    //  */
    // private $evenement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDisponibilite(): ?bool
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(?bool $disponibilite): self
    {
        $this->disponibilite = $disponibilite;

        return $this;
    }

    // public function getPhoto(): ?Photo
    // {
    //     return $this->photo;
    // }

    // public function setPhoto(?Photo $photo): self
    // {
    //     $this->photo = $photo;

    //     return $this;
    // }

//     public function getEvenement(): ?Evenement
//     {
//         return $this->evenement;
//     }

//     public function setEvenement(?Evenement $evenement): self
//     {
//         $this->evenement = $evenement;

//         return $this;
//     }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;
    }
}
