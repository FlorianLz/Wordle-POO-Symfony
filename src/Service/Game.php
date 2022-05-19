<?php

namespace App\Service;

class Game
{
    private Word $word;
    public int $essais_restants;
    public bool $alreadyStarted = false;
    public array $tentatives = [];
    private string $status;
    private GameData $gameData;
    private string $motPropose = "";

    public function __construct()
    {
        $this->gameData = new GameData();
    }

    public function initGame()
    {
        $gameStarted = $this->gameData->isGameStarted();

        if ($gameStarted) {
            $this->setPlayingGame();
            return;
        }
        $this->setNewGame();
    }

    public function startGame() : array {
        $object = [
            'word' => $this->word->getWord(),
            'word_count' => $this->word->getLength(),
            'essais_restants' => $this->essais_restants,
            'tentatives' => $this->tentatives,
            'tabLettres' => $this->word->getTabOfLetters(),
            'status' => $this->status
        ];
        $this->gameData->setGameData(json_encode($object));
        return $object;
    }

    private function setNewGame(){
        $loadWords = new LoadWords();
        $selectWords = new SelectWords();
        $words = json_decode($loadWords->getWords(),true);
        $randomWord = $selectWords->getRandomWord($words);
        $this->word = new Word($randomWord);
        $this->essais_restants = 6;
        $this->status = 'PLAYING';
    }

    private function setPlayingGame()
    {
        $game = $this->gameData->getGameData();
        $this->word = new Word(json_decode($game)->word);
        $this->alreadyStarted = true;
        $this->essais_restants = json_decode($game)->essais_restants;
        $this->tabLettres = json_decode($game)->tabLettres;
        $this->tentatives = json_decode($game)->tentatives;

        if($this->essais_restants > 0) {
            $this->setProposition();
            if($this->motPropose == $this->word->getWord()) {
                $this->status = 'WIN';
                $this->essais_restants = 0;
                $this->gameData->deleteGameData();
            } else {
                $this->status = 'PLAYING';
                if($this->essais_restants == 0) {
                    $this->status = 'LOSE';
                }
            }

        }
    }

    private function setProposition(){
        if(isset($_GET['letter0'])) {
            $tabTentative = [];
            $this->essais_restants--;
            //Vérifier si les lettres proposées sont dans le mot
            for($i=0; $i < $this->word->getLength(); $i++) {
                $letter = new Letter($_GET["letter$i"],$i);
                $this->motPropose .= $letter->getLetter();
                if($letter->isInWord($this->word)) {
                    //Lettre dans le mot
                    if($letter->isInGoodPosition($this->word)) {
                        //Lettre à la bonne position
                        $tabTentative[$i] = ['letter' => $letter->getLetter(), 'status' => 'OK'];
                    } else {
                        //Lettre dans la mauvaise position
                        $tabTentative[$i] = ['letter' => $letter->getLetter(), 'status' => 'BP'];
                    }
                }else{
                    //Lettre pas dans le mot
                    $tabTentative[$i] = ['letter' => $letter->getLetter(), 'status' => 'KO'];
                }
            }
            $this->tentatives[] = $tabTentative;
        }
    }
}