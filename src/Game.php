<?php

namespace App;

use App\Mapper\GameMapper;
use App\Registry\ApplicationRegistry;
use Throwable;
use App\Model\Game as GameModel;

/**
 * Class Game
 *
 * @author Sholom Yurii <sholomka@gmail.com>
 */
class Game
{
    private const NUMBER_OF_GAMES = 20;

    /**
     * @var Aplayer $aPlayer
     */
    private Aplayer $aPlayer;

    /**
     * @var Bplayer $bPlayer
     */
    private Bplayer $bPlayer;

    /**
     * @var string[] $results
     */
    private array $results = [
        'Draw',
        'A Player Win',
        'B Player Win',
    ];

    /**
     * @var GameMapper
     */
    private GameMapper $mapper;

    /**
     * Game constructor.
     *
     * @throws Exceptions\AppException
     */
    public function __construct()
    {
        ApplicationRegistry::instance()->init();
        $this->aPlayer = new Aplayer();
        $this->bPlayer = new Bplayer();
        $this->mapper = new GameMapper();
    }

    /**
     * @return $this
     * @throws Throwable
     */
    public function start(): self
    {
        for ($i = 1; $i <= self::NUMBER_OF_GAMES; $i++) {
            $this->aPlayer->makeChoice(Choice::PAPER);
            $this->bPlayer->makeChoice(random_int(Choice::SCISSORS, Choice::PAPER));
            $this->saveResults();
        }

        return $this;
    }

    /**
     * @return void
     */
    public function showResults(): void
    {
        $gameCollection = $this->mapper->findAll();
        $generator = $gameCollection->getGenerator();

        /** @var GameModel $gameModel */
        foreach ($generator as $gameModel) {
           $this->print($gameModel);
        }
    }

    /**
     * @throws Throwable
     * @return void
     */
    private function saveResults(): void
    {
        $aPlayerChoice = $this->aPlayer->getChoice();
        $bPlayerChoice = $this->bPlayer->getChoice();
        $gameModel = new GameModel();
        $gameModel->setAPlayerChoice(Choice::$items[$aPlayerChoice]);
        $gameModel->setBPlayerChoice(Choice::$items[$bPlayerChoice]);
        $gameModel->setResult($this->decidingWhoWon($aPlayerChoice, $bPlayerChoice));
        $this->mapper->insert($gameModel);
    }

    /**
     * @param int $aPlayerChoice
     * @param int $bPlayerChoice
     * @return string
     */
    private function decidingWhoWon(int $aPlayerChoice, int $bPlayerChoice): string
    {
        $itemsCount = count(Choice::$items);
        $result = ($aPlayerChoice - $bPlayerChoice) % $itemsCount;
        $won = $result < 0 ? $result + $itemsCount : $result;

        return  $this->results[$won];
    }

    /**
     * @param GameModel $gameModel
     * @return void
     */
    private function print(GameModel $gameModel): void
    {
        echo sprintf("Game: %d: A player choice: %s; B player choice: %s; Result: %s",
                $gameModel->getId(),
                $gameModel->getAPlayerChoice(),
                $gameModel->getBPlayerChoice(),
                $gameModel->getResult()
            ) . PHP_EOL;
    }
}
