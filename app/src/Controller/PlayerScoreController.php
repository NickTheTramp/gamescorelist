<?php

namespace App\Controller;

use App\Entity\PlayedGame;
use App\Entity\PlayerScore;
use App\Form\PlayerScoreType;
use App\Repository\PlayerScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/playedgame/{playedGame}/playerscore', name: 'playerscore_')]
class PlayerScoreController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function newAction(int $playedGame, Request $request, EntityManagerInterface $em): Response
    {
        $playerScore = new PlayerScore();
        $playerScore->setPlayedGame($em->getReference(PlayedGame::class, $playedGame));

        $form = $this->createForm(PlayerScoreType::class, $playerScore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var PlayerScore $playerScore */
            $playerScore = $form->getData();

            $em->persist($playerScore);
            $em->flush();

            return $this->redirectToRoute('playedgame_edit', ['id' => $playerScore->getPlayedGame()->getId()]);
        }

        return $this->renderForm('playerscore/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'edit')]
    public function editAction(int $playedGame, int $id, Request $request, EntityManagerInterface $em, PlayerScoreRepository $playerScoreRepository): Response
    {
        $playerScore = $playerScoreRepository->find($id);

        $form = $this->createForm(PlayerScoreType::class, $playerScore);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            /** @var PlayerScore $playerScore */
            $playerScore = $form->getData();

            $em->persist($playerScore);
            $em->flush();

            return $this->redirectToRoute('playedgame_edit', ['id' => $playerScore->getPlayedGame()->getId()]);
        }

        return $this->renderForm('playerscore/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteAction(int $id, EntityManagerInterface $em, PlayerScoreRepository $playerScoreRepository): Response
    {
        $playerScore = $playerScoreRepository->find($id);

        $em->remove($playerScore);
        $em->flush();

        return $this->redirectToRoute('game_edit', ['id' => $playerScore->getPlayedGame()->getId()]);
    }
}
