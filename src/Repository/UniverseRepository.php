<?php

namespace App\Repository;

use App\Entity\Universe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @method Universe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Universe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Universe[]    findAll()
 * @method Universe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UniverseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Universe::class);
    }

    /**
     * @return Universe[]
     */
    public function findTopUniversesAfterDate(\DateTime $after, int $nbMaxResult)
    {
        $results = $this->createQueryBuilder('u')
            ->addSelect('count(m.id)')
            ->leftJoin('u.stories', 's')
            ->leftJoin('s.chapters', 'c')
            ->leftJoin('c.messages', 'm')
            ->andWhere('m.creationDate > :date')
            ->setParameter('date', $after)
            ->groupBy('u')
            ->addOrderBy(new OrderBy('count(m.id)', 'DESC'))
            ->setMaxResults($nbMaxResult)
            ->getQuery()
            ->getResult();

        $universes = new ArrayCollection();
        foreach ($results as $result) {
            $universes[] = $result[0];
        }   
        return $universes;
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
