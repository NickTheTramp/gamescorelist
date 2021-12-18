<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Group;
use App\Entity\PlayedGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Internal\Hydration\ArrayHydrator;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarExporter\Internal\Hydrator;

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
    public function findBySelectedGroup(Group $group): array
    {
        return $this->createQueryBuilder('t0')
            ->leftJoin('t0.game', 't1')
            ->andWhere('t1.selectedGroup = :group')
            ->setParameter('group', $group->getId())
            ->getQuery()
            ->getResult();
    }

    /**
     * getAmountOfPlayedGames get the amount of playedGames by the given game
     *
     * @param Game $game
     * @param string|null $scoreFinal
     *
     * @return string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getAmountOfPlayedGames(Game $game, string $scoreFinal = null): string
    {
        $qb = $this->createQueryBuilder('t0')
            ->select('count(t0)')
            ->innerJoin('t0.game', 't1')
            ->where('t1 = :game')
            ->setParameter('game', $game);

        if (isset($scoreFinal)) {
            $qb
                ->andWhere('t0.scoreFinal = :scoreFinal')
                ->setParameter('scoreFinal', $scoreFinal);
        }

        return $qb
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * getAmountOfPlayedGamesPerGame returns the playedGames per game made in the group
     *
     * @param Game $game
     * @param string|null $scoreFinal
     *
     * @return array
     */
    public function getAmountOfPlayedGamesPerGame(Game $game, string $scoreFinal = null): array
    {
        $group = $game->getSelectedGroup();

        $qb = $this->createQueryBuilder('t0')
            ->select('t3.name', 'count(t0) as amount')
            ->leftJoin('t0.game', 't1')
            ->innerJoin('t0.selectedGroup', 't2')
            ->innerJoin('t0.gameMap', 't3')
            ->where('t2 = :selectedGroup')
            ->andWhere('t1.id = :game')
            ->setParameter('selectedGroup', $group)
            ->setParameter('game', $game->getId())
            ->groupBy('t3.name');

        if (isset($scoreFinal)) {
            $qb
                ->andWhere('t0.scoreFinal = :scoreFinal')
                ->setParameter('scoreFinal', $scoreFinal);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }
}
