<?php

namespace App\Service;

use App\Entity\Utilisateur;
use App\Entity\PaginatorResponse;

interface IUtilisateurService
{
  
    public function  recupererTousUtilisateurPagination(?int $page,?int $limit): PaginatorResponse;

    public function recupererTousUtilisateur(): array;
    public function recupererUtilisateurParId(int $id): array;
    public function enregistrerUtilisateur(Utilisateur $utilisateur): Utilisateur;

    public function mettreAjourUtilisateur(Utilisateur $utilisateur): bool;
    public function supprimerUtilisateur(int $id): bool;
    
}
