<?php

namespace App\Repository;

use App\Entity\MessageRead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MessageRead|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageRead|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageRead[]    findAll()
 * @method MessageRead[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageReadRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MessageRead::class);
    }

    // /**
    //  * @return MessageRead[] Returns an array of MessageRead objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessageRead
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
