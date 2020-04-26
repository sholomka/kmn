<?php

namespace App\Mapper;

use App\Collection\Collection;
use App\Exceptions\AppException;
use App\Model\DomainObject;
use App\Registry\ApplicationRegistry;
use PDO;
use PDOStatement;
use Throwable;

/**
 * Class Mapper
 *
 * @package App
 * @author Sholom Yurii <sholomka@gmail.com>
 */
abstract class Mapper
{
    /**
     * @var PDO $PDO
     */
    protected static PDO $PDO;

    /**
     * Mapper constructor.
     *
     * @throws AppException
     */
    public function __construct()
    {
        if (!isset(self::$PDO)) {
            $dsn = ApplicationRegistry::getDSN();

            if (is_null($dsn)) {
                throw new AppException("DSN not found");
            }

            $user = ApplicationRegistry::getUser();
            $password = ApplicationRegistry::getPassword();

            self::$PDO = new PDO($dsn, $user, $password);
            self::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
        $this->selectAllStmt()->execute([]);

        return $this->getCollection($this->selectAllStmt()->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * @param DomainObject $obj
     * @throws Throwable
     */
    public function insert(DomainObject $obj): void
    {
        try {
            self::$PDO->beginTransaction();
            $this->doInsert($obj);
            self::$PDO->commit();
        } catch (Throwable $e) {
            self::$PDO->rollBack();
            throw $e;
        }
    }

    /**
     * @param array $array
     * @return mixed
     */
    public function createObject(array $array)
    {
        return $this->doCreateObject($array);
    }

    /**
     * @return PDOStatement
     */
    protected abstract function selectAllStmt(): PDOStatement;

    /**
     * @return PDOStatement
     */
    protected abstract function insertStmt(): PDOStatement;

    /**
     * @param array $raw
     * @return Collection
     */
    protected abstract function getCollection(array $raw): Collection;

    /**
     * @param array $array
     * @return DomainObject
     */
    protected abstract function doCreateObject(array $array): DomainObject;

    /**
     * @param DomainObject $obj
     * @return mixed
     */
    protected abstract function doInsert(DomainObject $obj): void;
}
