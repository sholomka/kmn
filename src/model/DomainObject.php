<?php

namespace App\Model;

/**
 * Class DomainObject
 *
 * @package App\Domain
 * @author Sholom Yurii <sholomka@gmail.com>
 */
abstract class DomainObject
{
    /**
     * @var int|null $id
     */
    private ?int $id;

    /**
     * DomainObject constructor.
     *
     * @param int|null $id
     */
    public function __construct(
        int $id = null
    ) {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}
