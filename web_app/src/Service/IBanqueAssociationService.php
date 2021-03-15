<?php

namespace App\Service;

use App\Entity\BanqueAssociation;
use App\Entity\PaginatorResponse;

interface IBanqueAssociationService
{
  
    public function  recupererTousBanqueAssociationPagination(?int $page,?int $limit): PaginatorResponse;

    public function recupererTousBanqueAssociation(): array;
    public function recupererBanqueAssociationParId(int $id): array;
    public function enregistrerBanqueAssociation(BanqueAssociation $banqueAssociation): BanqueAssociation;

    public function mettreAjourBanqueAssociation(BanqueAssociation $banqueAssociation): bool;
    public function supprimerBanqueAssociation(int $id): bool;
    
}
