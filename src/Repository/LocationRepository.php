<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Location::class);
    }

    /**
     * @return Location[] Returns an array of Location objects
     */
    public function findLocationsByUniverseId(int $idUniverse)
    {
        return new ArrayCollection(
            $this->createQueryBuilder('l')
                ->andWhere('l.universe = :id_universe')
                ->setParameter('id_universe', $idUniverse)
                ->orderBy('l.name', 'ASC')
                ->getQuery()
                ->getResult()
        );
    }

    /*
    public function findOneBySomeField($value): ?Location
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
     */
}
