<?php

namespace App\Controller;

use App\Entity\PlayedGame;
use App\Form\PlayedGameType;
use App\Repository\GameRepository;
use App\Repository\PlayedGameRepository;
use App\Repository\PlayerScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/playedgame', name: 'playedgame_')]
class PlayedGameController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PlayedGameRepository $playedGameRepository, GameRepository $gameRepository): Response
    {
        $playedGames = $playedGameRepository->findAll();

        return $this->render('playedgame/index.html.twig', [
            'playedGames' => $playedGames,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function newAction(Request $request, EntityManagerInterface $em): Response
    {
        $playedGame = new PlayedGame();
        $form = $this->createForm(PlayedGameType::class, $playedGame);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $playedGame = $form->getData();

            $em->persist($playedGame);
            $em->flush();
            $em->refresh($playedGame);

            return $this->redirectToRoute('playedgame_edit', ['id' => $playedGame->getId()]);
        }

        return $this->renderForm('playedgame/form.html.twig', [
            'form' => $form,
            'playedGame' => $playedGame,
            'playerScores' => [],
        ]);
    }

    #[Route('/{id}', name: 'edit')]
    public function editAction(int $id, Request $request, EntityManagerInterface $em, PlayerScoreRepository $playerScoreRepository): Response
    {
        $playedGame = $em->getRepository(PlayedGame::class)->find($id);
        $form = $this->createForm(PlayedGameType::class, $playedGame);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PlayedGame $playedGame */
            $playedGame = $form->getData();

            $em->persist($playedGame);
            $em->flush();
            $em->refresh($playedGame);

            return $this->redirectToRoute('playedgame_edit', ['id' => $playedGame->getId()]);
        }

        $playerScores = $playerScoreRepository->findBy(['playedGame' => $playedGame]);

        return $this->renderForm('playedgame/form.html.twig', [
            'form' => $form,
            'playedGame' => $playedGame,
            'playerScores' => $playerScores,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteAction(int $id, EntityManagerInterface $em): Response
    {
        $playedGame = $em->getRepository(PlayedGame::class)->find($id);

        $em->remove($playedGame);
        $em->flush();

        return $this->redirectToRoute('playedgame_index');
    }
}
