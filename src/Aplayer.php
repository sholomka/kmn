<?php

namespace App;

/**
 * Class Aplayer
 *
 * @author Sholom Yurii <sholomka@gmail.com>
 */
class Aplayer extends Player
{
    /**
     * @param int $choice
     */
    public function makeChoice(int $choice): void
    {
        $this->choice = $choice;
    }
}
