<?php

namespace App\Chart\Data;

use App\Entity\Game;
use App\Entity\Group;
use App\Entity\PlayedGame;
use App\Repository\PlayedGameRepository;
use App\Repository\PlayerScoreRepository;
use Doctrine\ORM\AbstractQuery;

class ChartDataService
{
    private PlayedGameRepository $playedGameRepository;
    private PlayerScoreRepository $playerScoreRepository;

    public function __construct(
        PlayedGameRepository $playedGameRepository,
        PlayerScoreRepository $playerScoreRepository
    ) {
        $this->playedGameRepository = $playedGameRepository;
        $this->playerScoreRepository = $playerScoreRepository;
    }

    /**
     * Calculate overall Winrate
     */
    public function getOverallWinrate(Game $game): array
    {
        $wonGames = (int) $this->playedGameRepository->getAmountOfPlayedGames($game, PlayedGame::SCOREFINAL_WIN);
        $lostGames = (int) $this->playedGameRepository->getAmountOfPlayedGames($game, PlayedGame::SCOREFINAL_LOSS);

        return ['wins' => $wonGames, 'losses' => $lostGames];
    }

    /**
     * Calculate Winrate per Game map
     */
    public function getWinratePerMap(Game $game): array
    {
        $data = [];
        $playedGames = $this->playedGameRepository->getAmountOfPlayedGamesPerGame($game);
        $wonGames = $this->playedGameRepository->getAmountOfPlayedGamesPerGame($game, PlayedGame::SCOREFINAL_WIN);

        foreach ($playedGames as $index => $game) {
            $key = array_search($game['name'], array_column($wonGames, 'name'));

            $wonGamesPerGame = 0;

            if (isset($wonGames[$key])) {
                $wonGamesPerGame = (int) $wonGames[$key]['amount'];
            }

            $winrate = ($wonGamesPerGame / (int) $game['amount']) * 100;

            $data[] = [
                'game' => $game['name'],
                'winrate' => $winrate
            ];

            unset($wonGames[$index]);
        }

        return $data;
    }
}
