<?php

namespace App\Collection;

/**
 * Class GameCollection
 *
 * @package App\Collection
 * @author Sholom Yurii <sholomka@gmail.com>
 */
class GameCollection extends Collection
{
    /**
     * @return string
     */
    protected function targetClass(): string
    {
        return get_class();
    }
}
