<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Group;
use App\Form\GameType;
use App\Repository\GameMapRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game', name: 'game_')]
class GameController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $em): Response
    {
        $games = $em->getRepository(Game::class)->findAll();

        return $this->render('game/index.html.twig', [
            'games' => $games,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function newAction(Request $request, EntityManagerInterface $em): Response
    {
        $game = new Game();

        /** @var Group $selectedGroup */
        $selectedGroup = $this->getUser()->getSelectedGroup();

        if (!is_null($selectedGroup)) {
            $game->setSelectedGroup($selectedGroup);
        }

        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Game $game */
            $game = $form->getData();

            $em->persist($game);
            $em->flush();
            $em->refresh($game);

            return $this->redirectToRoute('game_edit', ['id' => $game->getId()]);
        }

        return $this->renderForm('game/form.html.twig', [
            'form' => $form,
            'gameMaps' => [],
            'game' => $game,
        ]);
    }

    #[Route('/{id}', name: 'edit')]
    public function editAction(int $id, Request $request, EntityManagerInterface $em, GameMapRepository $gameMapRepository): Response
    {
        $game = $em->getRepository(Game::class)->find($id);
        $form = $this->createForm(GameType::class, $game);
        $gameMaps = $gameMapRepository->findBy(['game' => $game]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Game $game */
            $game = $form->getData();

            $em->persist($game);
            $em->flush();

            // return $this->redirectToRoute('game_edit', ['id' => $game->getId()]);
        }

        return $this->renderForm('game/form.html.twig', [
            'form' => $form,
            'gameMaps' => $gameMaps,
            'game' => $game,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteAction(int $id, EntityManagerInterface $em): Response
    {
        $game = $em->getRepository(Game::class)->find($id);

        $em->remove($game);
        $em->flush();

        return $this->redirectToRoute('game_index');
    }
}
