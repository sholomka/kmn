<?php

namespace App\Registry;

/**
 * Class Registry
 *
 * @package App\Registry
 * @author Sholom Yurii <sholomka@gmail.com>
 */
abstract class Registry
{
    /**
     * @param string $value
     * @return mixed
     */
    abstract protected function get(string $value);

    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    abstract protected function set(string $key, string $value);
}
