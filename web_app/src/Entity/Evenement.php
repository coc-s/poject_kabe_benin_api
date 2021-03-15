<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EvenementRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
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
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $date;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
