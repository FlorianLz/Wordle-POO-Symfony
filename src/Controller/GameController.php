<?php

namespace App\Controller;

use App\Service\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * @Route("/", name="home_game")
     */
    public function index(): Response
    {
        $game = new Game();
        $game->initGame();
        $wordle = json_decode(json_encode($game->startGame()), FALSE);
        return $this->render('game/index.html.twig', [
            'wordle' => $wordle,
        ]);
    }
}
