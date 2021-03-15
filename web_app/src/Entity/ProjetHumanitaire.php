<?php

namespace App\Entity;

use App\Entity\Photo;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjetHumanitaireRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProjetHumanitaireRepository::class)
 */
class ProjetHumanitaire
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
     * @ORM\Column(type="string", length=5000, nullable=true)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Photo::class)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $photo;

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
