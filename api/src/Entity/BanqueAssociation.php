<?php

namespace App\Entity;

use App\Entity\Don;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BanqueAssociationRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BanqueAssociationRepository::class)
 */
class BanqueAssociation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $totalDons;

    /**
     * @ORM\ManyToOne(targetEntity=Don::class)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $don;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalDons(): ?float
    {
        return $this->totalDons;
    }

    public function setTotalDons(?float $totalDons): self
    {
        $this->totalDons = $totalDons;

        return $this;
    }

    public function getDon(): ?Don
    {
        return $this->don;
    }

    public function setDon(?Don $don): self
    {
        $this->don = $don;

        return $this;
    }
}
