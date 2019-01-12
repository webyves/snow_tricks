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
}
