<?php

/*
 * This file is part of the Framewa project.
 *
 * (c) Adrien H <adrien.h@tuta.io>
 *
 * This micro-framework has been developed for pedagogic purpose
 * at the 3WA school and is not meant for production.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Framewa\Config;

/**
 * Class ConfigReader
 * @package Framewa\Config
 */
final class ConfigReader
{
    /** @var Config $database */
    private Config $database;

    /** @var Config $routes */
    private Config $routes;

    /** @var Config $authentication */
    private Config $authentication;

    /** @var Config $parameters */
    private Config $parameters;

    /**
     * ConfigReader constructor.
     */
    public function __construct()
    {
        $this->database = new Config('config/database.php');
        $this->routes = new Config('config/routes.php');
        $this->authentication = new Config('config/authentication.php');
        $this->parameters = new Config('config/parameters.php');
    }

    /**
     * @return Config
     */
    public function getDatabase(): Config
    {
        return $this->database;
    }

    /**
     * @return Config
     */
    public function getRoutes(): Config
    {
        return $this->routes;
    }

    /**
     * @return Config
     */
    public function getAuthentication(): Config
    {
        return $this->authentication;
    }

    /**
     * @return Config
     */
    public function getParameters(): Config
    {
        return $this->parameters;
    }
}
