<?php

namespace App\Entity;

use App\Entity\Utilisateur;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})

     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})

     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Set the value of id
     */ 
    public function setId($id)
    {
        $this->id = $id;

    }
}
