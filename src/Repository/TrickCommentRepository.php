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
}
