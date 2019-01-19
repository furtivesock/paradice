<?php

namespace App\Repository;

use App\Entity\Visibility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Visibility|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visibility|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visibility[]    findAll()
 * @method Visibility[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisibilityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Visibility::class);
    }

    // /**
    //  * @return Visibility[] Returns an array of Visibility objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Visibility
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
