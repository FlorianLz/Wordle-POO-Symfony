<?php

namespace App\Service;

class SelectWords
{
    public function getRandomWord(array $words)
    {
        $randomIndex = rand(0, count($words) - 1);
        return $words[$randomIndex];
    }
}