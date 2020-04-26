<?php

namespace App;

/**
 * Class Choice
 *
 * @author Sholom Yurii <sholomka@gmail.com>
 */
final class Choice implements Choices
{
    /**
     * @var array|string[] $items
     */
    public static array $items = [
        self::SCISSORS => 'scissors',
        self::STONE => 'stone',
        self::PAPER => 'paper'
    ];
}
