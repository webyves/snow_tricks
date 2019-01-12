<?php

namespace App\Repository;

use App\Entity\TrickImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TrickImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickImage[]    findAll()
 * @method TrickImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TrickImage::class);
    }
}
