<?php

namespace App\Model;

/**
 * Class Game
 *
 * @package App\Domain
 * @author Sholom Yurii <sholomka@gmail.com>
 */
class Game extends DomainObject
{
    /**
     * @var string $a_player_choice
     */
    private string $a_player_choice;

    /**
     * @var string $b_player_choice
     */
    private string $b_player_choice;

    /**
     * @var string $result
     */
    private string $result;

    /**
     * @param string $a_player_choice
     */
    public function setAPlayerChoice(string $a_player_choice): void
    {
        $this->a_player_choice = $a_player_choice;
    }

    /**
     * @param string $b_player_choice
     */
    public function setBPlayerChoice(string $b_player_choice): void
    {
        $this->b_player_choice = $b_player_choice;
    }

    /**
     * @param string $result
     */
    public function setResult(string $result): void
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getAPlayerChoice(): string
    {
        return $this->a_player_choice;
    }

    /**
     * @return string
     */
    public function getBPlayerChoice(): string
    {
        return $this->b_player_choice;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }
}
