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
     * @return Story[] Returns an array of Story objects
     */
    public function findStoriesOrderedByLastUpdate(int $idUniverse) : Collection
    {
        $results = $this->createQueryBuilder('s')
            ->addSelect('max(m.creationDate)')
            ->leftJoin('s.chapters', 'c')
            ->leftJoin('c.messages', 'm')
            ->andWhere('s.universe = :id_universe')
            ->addGroupBy('s')
            ->addOrderBy(new OrderBy('max(m.creationDate)', 'DESC'))
            ->setParameter('id_universe', $idUniverse)
            ->getQuery()
            ->getResult();

        $stories = new ArrayCollection();
        foreach ($results as $result) {
            $stories[] = $result[0]; // only get Story Entities (without creationDate)
        }

        return $stories;
    }

    /**
     * @return Story[] Returns an array of Story objects
     */
    public function findStoriesOrderedByCreationDate(int $idUniverse) : Collection
    {
        $results = $this->createQueryBuilder('s')
            ->andWhere('s.universe = :id_universe')
            ->addOrderBy(new OrderBy('s.creationDate', 'DESC'))
            ->setParameter('id_universe', $idUniverse)
            ->getQuery()
            ->getResult();

        return new ArrayCollection($results);
    }

    /**
     * @return Story[] Returns an array of Story objects
     */
    public function findStoriesOrderedByActivity(int $idUniverse, string $order) : Collection
    {

        switch ($order) {
            case 'top_day':
                $date = (new \DateTime())->sub(new \DateInterval('P1D'));
                break;
            case 'top_week':
                $date = (new \DateTime())->sub(new \DateInterval('P1W'));
                break;
            case 'top_month':
                $date = (new \DateTime())->sub(new \DateInterval('P1M'));
                break;
            case 'top_year':
                $date = (new \DateTime())->sub(new \DateInterval('P1D'));
                break;
        }

        $results = $this->createQueryBuilder('s')
            ->addSelect('count(m.id)')
            ->leftJoin('s.chapters', 'c')
            ->leftJoin('c.messages', 'm')
            ->andWhere('s.universe = :id_universe')
            ->addGroupBy('s')
            ->addOrderBy(new OrderBy('count(m.id)', 'DESC'))
            ->setParameter('id_universe', $idUniverse);

        if ($order !== 'top_all') {
            $results = $results
                ->andWhere('m.creationDate > :date')
                ->setParameter('date', $date);
        }

        $results = $results
            ->getQuery()
            ->getResult();


        return new ArrayCollection(
            array_map(function ($result) {
                return $result[0];
            }, $results)
        );
    }

    /*
    public function findOneBySomeField($value): ?Story
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
