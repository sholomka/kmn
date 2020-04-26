<?php

namespace App\Registry;

use App\Exceptions\AppException;

/**
 * Class ApplicationRegistry
 *
 * @package App
 * @author Sholom Yurii <sholomka@gmail.com>
 */
class ApplicationRegistry extends Registry
{
    /**
     * @var ApplicationRegistry|null $instance
     */
    private static ?ApplicationRegistry $instance = null;

    /**
     * @var array
     */
    private array $values = [];

    /**
     * @var string $config
     */
    private string $config;

    /**
     * ApplicationRegistry constructor.
     */
    public function __construct()
    {
        $this->config = realpath(implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'config', 'config.php']));
    }

    /**
     * @return void
     * @throws AppException
     */
    public function init(): void
    {
        $dsn = self::getDSN();

        if (!is_null($dsn)) {
            return;
        }

        $this->getOptions();
    }

    /**
     * @return static
     */
    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return string|null
     */
    public static function getDSN(): ?string
    {
        return self::instance()->get('dsn');
    }

    /**
     * @return string|null
     */
    public static function getUser(): ?string
    {
        return self::instance()->get('user');
    }

    /***
     * @return string|null
     */
    public static function getPassword(): ?string
    {
        return self::instance()->get('password');
    }

    /**
     * @param string $key
     * @return string|null
     */
    protected function get(string $key): ?string
    {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }

        return null;
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    protected function set(string $key, string $value): void
    {
        $this->values[$key] = $value;
    }

    /**
     * @return void
     * @throws AppException
     */
    private function getOptions(): void
    {
        if (!file_exists($this->config)) {
            throw new AppException("Configuration file not found");
        }

        $options = require_once $this->config;

        $dsn = $options['dsn'];
        $user = $options['user'];
        $password = $options['password'];

        if (is_null($dsn)) {
            throw new AppException("DSN not found");
        }

        self::setDsn($dsn);
        self::setUser($user);
        self::setPassword($password);
    }

    /**
     * @param string $password
     * @retun void
     */
    private static function setPassword(string $password): void
    {
        self::instance()->set('password', $password);
    }

    /**
     * @param string $user
     * @retun void
     */
    private static function setUser(string $user): void
    {
        self::instance()->set('user', $user);
    }

    /**
     * @param string $dsn
     * @return void
     */
    private static function setDsn(string $dsn): void
    {
        self::instance()->set('dsn', $dsn);
    }
}
