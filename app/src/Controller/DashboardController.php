<?php

namespace App\Controller;

use App\Chart\ChartService;
use App\Entity\User;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Model\Chart;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(
        Request $request,
        GameRepository $gameRepository,
        ChartService $chartService
    ): Response {
        /** @var User $user */
        $user = $this->getUser();

        /** @var Chart[] $charts */
        $charts = [];

        $games = $gameRepository->findBy(['selectedGroup' => $user->getSelectedGroup()]);

        if ($request->get('game') !== null) {
            $selectedGame = $gameRepository->find((int) $request->get('game'));
        } else {
            $selectedGame = $games[0];
        }

        $charts[] = $chartService->createChart();

        return $this->render('dashboard/index.html.twig', [
            'charts' => $charts,
            'games' => $games,
            'selectedGame' => $selectedGame,
        ]);
    }
}
