<?php

namespace App\Repository;

use App\Entity\TrickComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrickComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickComment[]    findAll()
 * @method TrickComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrickComment::class);
    }

    // /**
    //  * @return TrickComment[] Returns an array of TrickComment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrickComment
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
