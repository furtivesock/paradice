<?php

namespace App\Repository;

use App\Entity\Chapter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Chapter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chapter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chapter[]    findAll()
 * @method Chapter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChapterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Chapter::class);
    }

    // /**
    //  * @return Chapter[] Returns an array of Chapter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findOneByUniverseAndStoryAndChapterId(int $idUniverse, int $idStory, int $idChapter) : ? Chapter
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.story', 's')
            ->andWhere('s.universe = :id_universe')
            ->andWhere('c.story = :id_story')
            ->andWhere('c.id = :id_chapter')
            ->setParameter('id_universe', $idUniverse)
            ->setParameter('id_story', $idStory)
            ->setParameter('id_chapter', $idChapter)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
