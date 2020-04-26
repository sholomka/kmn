<?php

require __DIR__ . '/vendor/autoload.php';

use App\Game;

try {
    (new Game())->start()->showResults();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}
