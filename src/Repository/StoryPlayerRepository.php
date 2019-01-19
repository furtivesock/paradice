<?php

namespace App\Repository;

use App\Entity\StoryPlayer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StoryPlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoryPlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoryPlayer[]    findAll()
 * @method StoryPlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryPlayerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StoryPlayer::class);
    }

    // /**
    //  * @return StoryPlayer[] Returns an array of StoryPlayer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StoryPlayer
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
