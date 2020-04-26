<?php

namespace App;

/**
 * Class Bplayer
 *
 * @author Sholom Yurii <sholomka@gmail.com>
 */
class Bplayer extends Player
{
    /**
     * @param int $choice
     */
    public function makeChoice(int $choice): void
    {
        $this->choice = $choice;
    }
}
