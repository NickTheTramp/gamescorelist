<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/games', name: 'games_')]
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
        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();

            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('games_index');
        }

        return $this->renderForm('game/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'edit')]
    public function editAction(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $game = $em->getRepository(Game::class)->find($id);
        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();

            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('games_index');
        }

        return $this->renderForm('game/form.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function deleteAction(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $game = $em->getRepository(Game::class)->find($id);

        $em->remove($game);
        $em->flush();

        return $this->redirectToRoute('games_index');
    }
}
