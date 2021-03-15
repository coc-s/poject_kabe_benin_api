<?php

namespace App\Service;

use App\Entity\Don;
use App\Entity\PaginatorResponse;

interface IDonService
{
  
    public function  recupererTousDonPagination(?int $page,?int $limit): PaginatorResponse;

    public function recupererTousDon(): array;
    public function recupererDonParId(int $id): array;
    public function enregistrerDon(Don $Don): Don;

    public function mettreAjourDon(Don $Don): bool;
    public function supprimerDon(int $id): bool;
    
}
