<?php

namespace App\Service;

class Letter
{
    public string $letter;
    public int $position;

    public function __construct($letter,$position)
    {
        $this->letter = $letter;
        $this->position = $position;
    }

    public function isInWord(Word $word): bool
    {
        $tabWord = $word->getTabOfLetters();
        foreach ($tabWord as $value) {
            if ($this->getLetter() == $value->getLetter()) {
                return true;
            }
        }
        return false;
    }

    public function isInGoodPosition(Word $word): bool
    {
        $tabWord = $word->getTabOfLetters();
        foreach ($tabWord as $key => $value) {
            if ($this->getLetter() == $value->getLetter() && $this->position == $key) {
                return true;
            }
        }
        return false;
    }

    public function getLetter(): string
    {
        return $this->letter;
    }
}