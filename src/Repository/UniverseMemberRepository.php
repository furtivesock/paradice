<?php

namespace App\Repository;

use App\Entity\UniverseMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UniverseMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method UniverseMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method UniverseMember[]    findAll()
 * @method UniverseMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UniverseMemberRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UniverseMember::class);
    }

    // /**
    //  * @return UniverseMember[] Returns an array of UniverseMember objects
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
    public function findOneBySomeField($value): ?UniverseMember
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
