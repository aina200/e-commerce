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

namespace Framewa\Controller;

use Framewa\Auth\Authenticator;
use Framewa\Auth\Model\UserInterface;
use Framewa\Http\Router;
use Framewa\Service\Container;
use Framewa\View\View;

/**
 * Class Controller
 * @package Framewa\Controller
 */
abstract class Controller
{
    /** @var Container $container */
    protected Container $container;

    /** @var Router $router */
    protected Router $router;

    /** @var \PDO $connection */
    protected \PDO $connection;

    /** @var Authenticator|null $auth */
    protected ?Authenticator $auth;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->container = Container::createOnce();
        $this->router = $this->container->get('framewa.router');
        $this->connection = $this->container->get('framewa.database')->getConnection();
        $this->auth = $this->container->get('framewa.authenticator');
    }

    /**
     * @param string $templatePath
     * @param array<string, mixed> $data
     *
     * @return void
     */
    protected function displayView(string $templatePath, array $data = []): void
    {
        $view = new View($templatePath, $data);
        $view->display();
    }
}
