<?php

namespace App\Repository;

use App\Entity\PlayerScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlayerScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerScore[]    findAll()
 * @method PlayerScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerScore::class);
    }
}
