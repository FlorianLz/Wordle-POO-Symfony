<?php

namespace App\Service;

class LoadWords
{
    private string $words;
    private const FILE_PATH = 'https://localhost:8000/data/words.json';

    public function __construct()
    {
        //$this->words = file_get_contents(self::FILE_PATH, true);
        $this->words = json_encode([
          "0" => "camera",
          "1" => "maison",
          "2" => "classeur",
          "3" => "bureau",
          "4" => "tablette",
          "5" => "telephone",
          "6" => "aliment",
          "7" => "magasin"
        ]);
    }

    public function getWords(): string
    {
        return $this->words;
    }
}