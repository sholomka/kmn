<?php

require __DIR__ . '/vendor/autoload.php';

use App\Game;

$start = microtime(true);

try {
    (new Game())->start()->showResults();
} catch (Throwable $e) {
    echo $e->getMessage() . PHP_EOL;
}

$end = 'Время выполнения скрипта: ' . round(microtime(true) - $start, 10) . ' сек.';
echo $end . PHP_EOL;
