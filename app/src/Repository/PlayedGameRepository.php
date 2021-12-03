<?php

namespace App\Repository;

use App\Entity\Group;
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

    /**
     * findBySelectedGroup finds all the playedGames related to the user group.
     * 
     * @param Group $group
     * 
     * @return PlayedGame[]
     */
    public function findBySelectedGroup(Group $group)
    {
        return $this->createQueryBuilder('t0')
            ->leftJoin('t0.game', 't1')
            ->andWhere('t1.selectedGroup = :group')
            ->setParameter('group', $group->getId())
            ->getQuery()
            ->getResult();
    }
}
