<?php

namespace App\Service;

use App\Entity\Evenement;
use App\Entity\PaginatorResponse;

interface IEvenementService
{
  
    public function  recupererTousEvenementPagination(?int $page,?int $limit): PaginatorResponse;

    public function recupererTousEvenement(): array;
    public function recupererEvenementParId(int $id): array;
    public function enregistrerEvenement(Evenement $evenement): Evenement;

    public function mettreAjourEvenement(Evenement $evenement): bool;
    public function supprimerEvenement(int $id): bool;
    
}
