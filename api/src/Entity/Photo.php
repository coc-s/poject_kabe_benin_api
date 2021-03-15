<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PhotoRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2000, nullable=true)
     * @Groups({"listAdherentSimple","listAdherentFull","PaginationAdherent"})
     */
    private $url;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getUrl(): ?string
    {
        return $this->url;
    }
}
