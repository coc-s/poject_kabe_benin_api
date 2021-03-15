<?php

namespace App\Repository;

use App\Entity\BanqueAssociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method banqueAssociation|null find($id, $lockMode = null, $lockVersion = null)
 * @method banqueAssociation|null findOneBy(array $criteria, array $orderBy = null)
 * @method banqueAssociation[]    findAll()
 * @method banqueAssociation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BanqueAssociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BanqueAssociation::class);
    }

    // /**
    //  * @return banqueAssociation[] Returns an array of banqueAssociation objects
    //  */
    
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    


    public function findOneBySomeField($value): ?BanqueAssociation
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
  
}
