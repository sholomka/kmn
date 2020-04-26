<?php

namespace App\Collection;

use App\Mapper\Mapper;
use Generator;

/**
 * Class Collection
 *
 * @package App\Collection
 * @author Sholom Yurii <sholomka@gmail.com>
 */
abstract class Collection
{
    /**
     * @var Mapper|null $mapper
     */
    protected ?Mapper $mapper;

    /**
     * @var int $total
     */
    protected int $total = 0;

    /**
     * @var array $raw
     */
    protected array $raw = [];

    /**
     * @var array $objects
     */
    protected array $objects = [];

    /**
     * Collection constructor.
     *
     * @param array $raw
     * @param Mapper $mapper
     */
    public function __construct(array $raw, Mapper $mapper)
    {
        $this->raw = $raw;
        $this->total = count($raw);
        $this->mapper = $mapper;
    }

    /**
     * @return Generator
     */
    public function getGenerator(): Generator
    {
        for ($x = 0; $x < $this->total; $x++) {
            yield ($this->getRow($x));
        }
    }

    /**
     * @param int $num
     * @return object|null
     */
    private function getRow(int $num): ?object
    {
        if ($num >= $this->total || $num < 0) {
            return null;
        }

        if (isset($this->raw[$num])) {
            $this->objects[$num] = $this->mapper->createObject($this->raw[$num]);

            return $this->objects[$num];
        }

        return null;
    }

    /**
     * @return string
     */
    abstract protected function targetClass(): string;
}
