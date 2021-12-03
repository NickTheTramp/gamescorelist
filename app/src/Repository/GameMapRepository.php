<?php

namespace App\Repository;

use App\Entity\GameMap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GameMap|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameMap|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameMap[]    findAll()
 * @method GameMap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameMapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameMap::class);
    }
}
