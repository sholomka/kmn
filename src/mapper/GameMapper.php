<?php

namespace App\Mapper;

use App\Collection\GameCollection;
use App\Model\DomainObject;
use App\Model\Game;
use Exception;
use PDOStatement;

/**
 * Class GameMapper
 *
 * @package App\Mapper
 * @author Sholom Yurii <sholomka@gmail.com>
 */
class GameMapper extends Mapper
{
    private const INSERT_SQL = 'INSERT INTO game (a_player_choice, b_player_choice, result) VALUES (?,?,?)';

    private const SELECT_ALL_SQL = 'SELECT id, a_player_choice, b_player_choice, result FROM game';

    /**
     * @var bool|PDOStatement
     */
    private $insertStmt;

    /**
     * @var bool|PDOStatement
     */
    private $selectAllStmt;

    /**
     * ResultMapper constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->insertStmt = self::$PDO->prepare(self::INSERT_SQL);
        $this->selectAllStmt = self::$PDO->prepare(self::SELECT_ALL_SQL);
    }

    /**
     * @param array $raw
     * @return GameCollection
     */
    public function getCollection(array $raw): GameCollection
    {
        return new GameCollection($raw, $this);
    }

    /**
     * @return PDOStatement
     */
    protected function selectAllStmt(): PDOStatement
    {
       return $this->selectAllStmt;
    }

    /**
     * @return PDOStatement
     */
    protected function insertStmt(): PDOStatement
    {
       return $this->insertStmt;
    }

    /**
     * @param array $array
     * @return Game
     */
    protected function doCreateObject(array $array): Game
    {
        $obj = new Game($array['id']);
        $obj->setAPlayerChoice($array['a_player_choice']);
        $obj->setBPlayerChoice($array['b_player_choice']);
        $obj->setResult($array['result']);

        return $obj;
    }

    /**
     * @param DomainObject $obj
     * @return void
     */
    protected function doInsert(DomainObject $obj): void
    {
        $values = [$obj->getAPlayerChoice(), $obj->getBPlayerChoice(), $obj->getResult()];
        $this->insertStmt()->execute($values);

        $id = self::$PDO->lastInsertId();
        $obj->setId($id);
    }
}
