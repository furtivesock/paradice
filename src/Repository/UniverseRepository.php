<?php

namespace App\Repository;

use App\Entity\Universe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Universe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Universe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Universe[]    findAll()
 * @method Universe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UniverseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Universe::class);
    }

    /**
     * Returns list of all universes after a given date and
     * with a specific order.
     *
     * @param string    $order The type of order. It can be :
     *                         - "update" : sort by last update
     *                         - "create" : sort by creation date
     *                         - "top" : sort by activity (number of message in this universe)
     * @param \DateTime $after (optional) Start date limit (inclusive)
     *
     * @return ArrayCollection
     */
    public function findAfterWithOrder(string $order, ?\DateTime $after)
    {
        switch ($order) {
            case 'update':
                $results = $this->createQueryBuilder('u')
                    ->addSelect('max(m.creationDate)')
                    ->leftJoin('u.stories', 's')
                    ->leftJoin('s.chapters', 'c')
                    ->leftJoin('c.messages', 'm')
                    ->addGroupBy('u')
                    ->addOrderBy(new OrderBy('max(m.creationDate)', 'DESC'));
                break;
            case 'create':
                $results = $this->createQueryBuilder('u')
                    ->addOrderBy(new OrderBy('u.creationDate', 'DESC'));
                break;
            case 'top':
                $results = $this->createQueryBuilder('u')
                    ->addSelect('count(m.id)')
                    ->leftJoin('u.stories', 's')
                    ->leftJoin('s.chapters', 'c')
                    ->leftJoin('c.messages', 'm')
                    ->addGroupBy('u')
                    ->addOrderBy(new OrderBy('count(m.id)', 'DESC'));
                break;
        }

        if (!is_null($after)) {
            $results = $results
                ->andWhere('u.creationDate > :date')
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

    // /**
    //  * @return Universe[] Returns an array of Universe objects
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
    public function findOneBySomeField($value): ?Universe
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
