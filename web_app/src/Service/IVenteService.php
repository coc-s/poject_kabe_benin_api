<?php

namespace App\Service;

use App\Entity\Vente;
use App\Entity\PaginatorResponse;

interface IVenteService
{
  
    public function  recupererTousVentePagination(?int $page,?int $limit): PaginatorResponse;

    public function recupererTousVente(): array;
    public function recupererVenteParId(int $id): array;
    public function enregistrerVente(Vente $vente): Vente;

    public function mettreAjourVente(Vente $vente): bool;
    public function supprimerVente(int $id): bool;
    
}
