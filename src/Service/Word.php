<?php

namespace App\Service;

class Word
{
    public string $word;

    public function __construct($mot)
    {
        $this->word = $mot;
    }

    public function getWord() : string
    {
        return $this->word;
    }

    public function getLength() : int
    {
        return strlen($this->word);
    }

    public function getTabOfLetters() : array
    {
        $letters = [];
        foreach (str_split($this->word) as $key=>$letter) {
            $letters[] = new Letter($letter,$key);
        }
        return $letters;
    }
}