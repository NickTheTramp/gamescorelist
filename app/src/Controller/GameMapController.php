<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\GameMap;
use App\Form\GameMapType;
use App\Repository\GameMapRepository;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/game/{game}/gamemap", name="gamemap_")
 */
class GameMapController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function newAction(
        int $game,
        Request $request,
        EntityManagerInterface $em,
        GameRepository $gameRepository
    ): Response {
        $gameMap = new GameMap();

        $form = $this->createForm(GameMapType::class, $gameMap);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var GameMap $gameMap */
            $gameMap = $form->getData();

            $game = $gameRepository->find($game);
            $gameMap->setGame($game);

            $em->persist($gameMap);
            $em->flush();

            return $this->redirectToRoute('game_edit', ['id' => $game->getId()]);
        }

        return $this->renderForm('gamemap/form.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="edit")
     */
    public function editAction(
        int $game,
        int $id,
        Request $request,
        EntityManagerInterface $em,
        GameRepository $gameRepository,
        GameMapRepository $gameMapRepository
    ): Response {
        $gameMap = $gameMapRepository->find($id);

        $form = $this->createForm(GameMapType::class, $gameMap);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var GameMap $gameMap */
            $gameMap = $form->getData();

            $game = $gameRepository->find($game);
            $gameMap->setGame($game);

            $em->persist($gameMap);
            $em->flush();

            return $this->redirectToRoute('game_edit', ['id' => $game->getId()]);
        }

        return $this->renderForm('gamemap/form.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction(
        int $game,
        int $id,
        EntityManagerInterface $em,
        GameRepository $gameRepository,
        GameMapRepository $gameMapRepository
    ): Response {
        $gameMap = $gameMapRepository->find($id);
        $game = $gameRepository->find($game);

        $em->remove($gameMap);
        $em->flush();

        return $this->redirectToRoute('game_edit', ['id' => $game->getId()]);
    }
}
