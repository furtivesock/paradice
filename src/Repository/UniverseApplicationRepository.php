<?php

namespace App\Repository;

use App\Entity\UniverseApplication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UniverseApplication|null find($id, $lockMode = null, $lockVersion = null)
 * @method UniverseApplication|null findOneBy(array $criteria, array $orderBy = null)
 * @method UniverseApplication[]    findAll()
 * @method UniverseApplication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UniverseApplicationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UniverseApplication::class);
    }

    // /**
    //  * @return UniverseApplication[] Returns an array of UniverseApplication objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UniverseApplication
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
