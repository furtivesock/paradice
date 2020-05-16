<?php

namespace App\Repository;

use App\Entity\OnlineUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OnlineUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method OnlineUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method OnlineUser[]    findAll()
 * @method OnlineUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OnlineUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OnlineUser::class);
    }

    // /**
    //  * @return OnlineUser[] Returns an array of OnlineUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OnlineUser
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
