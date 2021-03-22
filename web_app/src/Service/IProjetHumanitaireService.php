<?php

namespace App\Service;

use App\Entity\ProjetHumanitaire;
use App\Entity\PaginatorResponse;

interface IProjetHumanitaireService
{
  
    public function  recupererTousProjetHumanitairePagination(?int $page,?int $limit): PaginatorResponse;

    public function recupererTousProjetHumanitaire(): array;
    public function recupererProjetHumanitaireParId(int $id): array;
    public function enregistrerProjetHumanitaire(ProjetHumanitaire $projetHumanitaire): ProjetHumanitaire;

    public function mettreAjourProjetHumanitaire(ProjetHumanitaire $projetHumanitaire): bool;
    public function supprimerProjetHumanitaire(int $id): bool;
    
}
