<?php

namespace App\Service;

use App\Entity\Produit;
use App\Entity\PaginatorResponse;

interface IProduitService
{
  
    public function  recupererTousProduitPagination(?int $page,?int $limit): PaginatorResponse;

    public function recupererTousProduit(): array;
    public function recupererProduitParId(int $id): array;
    public function enregistrerProduit(Produit $produit): Produit;

    public function mettreAjourProduit(Produit $produit): bool;
    public function supprimerProduit(int $id): bool;
    
}
