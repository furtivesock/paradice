<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\OrderBy;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Message::class);
    }

    /**
     * Return a list of messages from a chapter within a certain range of date.
     *
     * If afterDate is omitted, it will give all stories from the
     * creation of the chapter
     *
     * @param int       $idUniverse Id of the chapter's universe
     * @param int       $idStory    Id of the chapter's story
     * @param int       $idChapter  Id of the chapter for the message
     * @param \DateTime $beforeDate inclusive end date
     * @param \DateTime $afterDate  inclusive start date, if omitted get all date
     *
     * @return ArrayCollection Returns an array of Message objects
     */
    public function findAfterAndBeforeDate(
        int $idUniverse,
        int $idStory,
        int $idChapter,
        \DateTime $beforeDate,
        ?\DateTime $afterDate
    ) {
        $results = $this->createQueryBuilder('m')
            ->leftJoin('m.chapter', 'c')
            ->leftJoin('c.story', 's')
            ->andWhere('c.id = :id_chapter')
            ->andWhere('s.id = :id_story')
            ->andWhere('s.universe = :id_universe')
            ->andWhere('m.creationDate <= :before_date')
            ->addOrderBy(new OrderBy('m.creationDate', 'ASC'))
            ->setParameter('id_chapter', $idChapter)
            ->setParameter('id_story', $idStory)
            ->setParameter('id_universe', $idUniverse)
            ->setParameter('before_date', $beforeDate);

        if (!is_null($afterDate)) {
            $results->andWhere('m.creationDate >= :after_date')
                ->setParameter('after_date', $afterDate);
        }

        $results = $results->getQuery()
            ->getResult();

        return new ArrayCollection($results);
    }

    /*
    public function findOneBySomeField($value): ?Message
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
