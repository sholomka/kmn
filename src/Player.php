<?php

namespace App;

/**
 * Class Player
 *
 * @author Sholom Yurii <sholomka@gmail.com>
 */
abstract class Player
{
    /**
     * @var int $choice
     */
    protected int $choice;

    /**
     * @param int $choice
     * @return void
     */
    abstract public function makeChoice(int $choice): void;

    /**
     * @return int
     */
    public function getChoice(): int
    {
        return $this->choice;
    }
}
