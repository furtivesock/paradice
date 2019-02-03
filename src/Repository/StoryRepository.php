<?php

namespace App\Repository;

use App\Entity\Story;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @method Story|null find($id, $lockMode = null, $lockVersion = null)
 * @method Story|null findOneBy(array $criteria, array $orderBy = null)
 * @method Story[]    findAll()
 * @method Story[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Story::class);
    }

    /**
     * @return Universe[]
     */
    public function findStoriesAfterDateAndOrdered(int $idUniverse, string $order, ? \DateTime $after)
    {


        switch ($order) {
            case 'update':
                $results = $this->createQueryBuilder('s')
                    ->addSelect('max(m.creationDate)')
                    ->leftJoin('s.chapters', 'c')
                    ->leftJoin('c.messages', 'm')
                    ->andWhere('s.universe = :id_universe')
                    ->addGroupBy('s')
                    ->addOrderBy(new OrderBy('max(m.creationDate)', 'DESC'))
                    ->setParameter('id_universe', $idUniverse);
                break;
            case 'create':
                $results = $this->createQueryBuilder('s')
                    ->andWhere('s.universe = :id_universe')
                    ->addOrderBy(new OrderBy('s.creationDate', 'DESC'))
                    ->setParameter('id_universe', $idUniverse);
                break;
            case 'top':
                $results = $this->createQueryBuilder('s')
                    ->addSelect('count(m.id)')
                    ->leftJoin('s.chapters', 'c')
                    ->leftJoin('c.messages', 'm')
                    ->andWhere('s.universe = :id_universe')
                    ->addGroupBy('s')
                    ->addOrderBy(new OrderBy('count(m.id)', 'DESC'))
                    ->setParameter('id_universe', $idUniverse);
                break;
        }

        if (!is_null($after)) {
            $results = $results
                ->andWhere('s.creationDate > :date')
                ->setParameter('date', $after);
        }

        $results = $results
            ->getQuery()
            ->getResult();


        if ($order === 'create') {
            return new ArrayCollection($results);
        }

        return new ArrayCollection(
            array_map(function ($result) {
                return $result[0];
            }, $results)
        );
    }


    public function findOneByUniverseAndStoryId(int $idUniverse, int $idStory) : ? Story
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.universe = :id_universe')
            ->andWhere('s.id = :id_story')
            ->setParameter('id_universe', $idUniverse)
            ->setParameter('id_story', $idStory)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
