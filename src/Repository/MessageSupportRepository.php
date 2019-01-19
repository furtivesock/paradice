<?php

namespace App\Repository;

use App\Entity\MessageSupport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MessageSupport|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageSupport|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageSupport[]    findAll()
 * @method MessageSupport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageSupportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MessageSupport::class);
    }

    // /**
    //  * @return MessageSupport[] Returns an array of MessageSupport objects
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
    public function findOneBySomeField($value): ?MessageSupport
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
