<?php

namespace App\Service;

use App\Entity\Adherent;
use App\Entity\PaginatorResponse;

interface IAdherentService
{
  
    public function  recupererTousAdherentPagination(?int $page,?int $limit): PaginatorResponse;

    public function recupererTousAdherent(): array;
    public function recupererAdherentParId(int $id): array;
    public function enregistrerAdherent(Adherent $adherent): Adherent;

    public function mettreAjourAdherent(Adherent $adherent): bool;
    public function supprimerAdherent(int $id): bool;
    
}
