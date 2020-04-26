<?php

namespace App\Tests;

use App\Aplayer;
use App\Bplayer;
use App\Mapper\GameMapper;
use App\Model\Game;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Throwable;

/**
 * Class GameTest
 *
 * @package App\Tests
 * @author Sholom Yurii <sholomka@gmail.com>
 */
class GameTest extends TestCase
{
    /**
     * @var GameMapper
     */
    private GameMapper $mapper;

    /**
     * @var Game|MockObject
     */
    private Game $gameModel;

    /**
     * @var Aplayer|MockObject
     */
    private Aplayer $aPlayer;

    /**
     * @var Bplayer|MockObject
     */
    private Bplayer $bPlayer;

    public function setUp(): void
    {
        $this->mapper = $this->createMock(GameMapper::class);
        $this->gameModel = $this->createMock(Game::class);
        $this->aPlayer = $this->createMock(Aplayer::class);
        $this->bPlayer = $this->createMock(Bplayer::class);
    }

    /**
     * @throws Throwable
     * @reutn void
     */
    public function testGameSaveResults(): void
    {
        $this->gameModel
            ->expects($this->once())
            ->method('setAPlayerChoice')
            ->with($this->logicalAnd(
                $this->isType('string'),
                $this->equalTo('paper'),
            ));

        $this->gameModel->setAPlayerChoice('paper');

        $this->gameModel
            ->expects($this->once())
            ->method('setBPlayerChoice')
            ->with($this->logicalAnd(
                $this->isType('string'),
                $this->logicalOr(
                    $this->equalTo('stone'),
                    $this->equalTo('paper'),
                    $this->equalTo('scissors'),
                )
            ));

        $this->gameModel->setBPlayerChoice('scissors');

        $this->gameModel
            ->expects($this->once())
            ->method('setResult')
            ->with($this->isType('string'));

        $this->gameModel->setResult('A Player Win');

        $this->mapper->expects($this->once())
            ->method('insert')
            ->with($this->isInstanceOf(Game::class))
            ->willThrowException(new \Exception('Insert Error'));

        try {
            $this->mapper->insert($this->gameModel);
        } catch (\Throwable $e) {
            self::assertEquals('Insert Error', $e->getMessage());
        }
    }
}
