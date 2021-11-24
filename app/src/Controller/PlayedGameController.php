<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/playedgames', name: 'playedgames_')]
class PlayedGameController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $number = random_int(0, 100);

        return $this->render('playedgame/index.html.twig', [
            'number' => $number,
        ]);
    }
}
