<?php

namespace App\Controller;

use App\Entity\PlayerScore;
use App\Form\PlayerScoreType;
use App\Repository\PlayedGameRepository;
use App\Repository\PlayerScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/playedgame/{playedGame}/playerscore", name="playerscore_")
 */
class PlayerScoreController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function newAction(
        int $playedGame,
        Request $request,
        EntityManagerInterface $em,
        PlayedGameRepository $playedGameRepository
    ): Response {
        $playerScore = new PlayerScore();

        $playedGame = $playedGameRepository->find($playedGame);
        $playerScore->setPlayedGame($playedGame);

        $form = $this->createForm(PlayerScoreType::class, $playerScore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var PlayerScore $playerScore */
            $playerScore = $form->getData();

            $em->persist($playerScore);
            $em->flush();

            return $this->redirectToRoute('playedgame_edit', ['id' => $playedGame->getId()]);
        }

        return $this->renderForm('playerscore/form.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="edit")
     */
    public function editAction(
        int $playedGame,
        int $id,
        Request $request,
        EntityManagerInterface $em,
        PlayerScoreRepository $playerScoreRepository,
        PlayedGameRepository $playedGameRepository
    ): Response {
        $playerScore = $playerScoreRepository->find($id);
        $playedGame = $playedGameRepository->find($playedGame);

        $form = $this->createForm(PlayerScoreType::class, $playerScore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var PlayerScore $playerScore */
            $playerScore = $form->getData();

            $em->persist($playerScore);
            $em->flush();

            return $this->redirectToRoute('playedgame_edit', ['id' => $playedGame->getId()]);
        }

        return $this->renderForm('playerscore/form.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction(
        int $playedGame,
        int $id,
        EntityManagerInterface $em,
        PlayerScoreRepository $playerScoreRepository,
        PlayedGameRepository $playedGameRepository
    ): Response {
        $playerScore = $playerScoreRepository->find($id);
        $playedGame = $playedGameRepository->find($playedGame);

        $em->remove($playerScore);
        $em->flush();

        return $this->redirectToRoute('playedgame_edit', ['id' => $playedGame->getId()]);
    }
}
