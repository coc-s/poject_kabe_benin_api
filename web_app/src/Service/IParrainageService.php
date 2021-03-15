<?php

namespace App\Service;

use App\Entity\Parrainage;
use App\Entity\PaginatorResponse;

interface IParrainageService
{
  
    public function  recupererTousParrainagePagination(?int $page,?int $limit): PaginatorResponse;

    public function recupererTousParrainage(): array;
    public function recupererParrainageParId(int $id): array;
    public function enregistrerParrainage(Parrainage $parrainage): Parrainage;

    public function mettreAjourParrainage(Parrainage $parrainage): bool;
    public function supprimerParrainage(int $id): bool;
    
}
