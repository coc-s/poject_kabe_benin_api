<?php

namespace App\Service;

use App\Entity\Admin;
use App\Entity\PaginatorResponse;

interface IAdminService
{
  
    public function  recupererTousAdminPagination(?int $page,?int $limit): PaginatorResponse;

    public function recupererTousAdmin(): array;
    public function recupererAdminParId(int $id): array;
    public function enregistrerAdmin(Admin $admin): Admin;

    public function mettreAjourAdmin(Admin $admin): bool;
    public function supprimerAdmin(int $id): bool;
    
}
