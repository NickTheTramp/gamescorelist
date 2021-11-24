<?php

namespace App\Repository;

use App\Entity\PlayedGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlayedGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayedGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayedGame[]    findAll()
 * @method PlayedGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayedGameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayedGame::class);
    }

    // /**
    //  * @return PlayedGame[] Returns an array of PlayedGame objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlayedGame
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
