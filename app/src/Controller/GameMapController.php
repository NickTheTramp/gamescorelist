<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\GameMap;
use App\Form\GameMapType;
use App\Form\GameType;
use App\Repository\GameMapRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game/{game}/gamemap', name: 'gamemap_')]
class GameMapController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function newAction(int $game, Request $request, EntityManagerInterface $em): Response
    {
        $gameMap = new GameMap();
        $form = $this->createForm(GameMapType::class, $gameMap);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var GameMap $gameMap */
            $gameMap = $form->getData();
            $gameMap->setGame($em->getReference(Game::class, $game));

            $em->persist($gameMap);
            $em->flush();

            return $this->redirectToRoute('game_edit', ['id' => $gameMap->getGame()->getId()]);
        }

        return $this->renderForm('gamemap/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'edit')]
    public function editAction(int $game, int $id, Request $request, EntityManagerInterface $em): Response
    {
        $gameMap = $em->getRepository(GameMap::class)->find($id);
        $form = $this->createForm(GameMapType::class, $gameMap);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var GameMap $gameMap */
            $gameMap = $form->getData();
            $gameMap->setGame($em->getReference(Game::class, $game));

            $em->persist($gameMap);
            $em->flush();

            return $this->redirectToRoute('game_edit', ['id' => $gameMap->getGame()->getId()]);
        }

        return $this->renderForm('gamemap/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteAction(int $id, EntityManagerInterface $em): Response
    {
        $gameMap = $em->getRepository(GameMap::class)->find($id);

        $em->remove($gameMap);
        $em->flush();

        return $this->redirectToRoute('game_edit', ['id' => $gameMap->getGame()->getId()]);
    }
}
