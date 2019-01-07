<?php

namespace App\Repository;

use App\Entity\UserTokens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserTokens|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTokens|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTokens[]    findAll()
 * @method UserTokens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTokensRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserTokens::class);
    }

    // /**
    //  * @return UserTokens[] Returns an array of UserTokens objects
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
    public function findOneBySomeField($value): ?UserTokens
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
