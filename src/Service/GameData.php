<?php

namespace App\Service;

class GameData
{
    public function isGameStarted(): bool{
        return (isset($_COOKIE['gameData']) && json_decode($_COOKIE['gameData'])->status === 'PLAYING');
    }

    public function getGameData(): string
    {
        return $_COOKIE['gameData'];
    }

    public function setGameData(string $gameData): void
    {
        setcookie('gameData', $gameData, time() + 3600, '/');
    }

    public function deleteGameData(): void
    {
        setcookie('gameData', '', time() - 3600, '/');
    }
}