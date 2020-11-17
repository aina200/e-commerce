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

namespace Framewa\Auth;

use Framewa\Config\Config;
use Framewa\Http\Router;
use Framewa\Model\ManagerInterface;
use Framewa\Model\ModelInterface;
use Framewa\Service\Container;

/**
 * Class Authenticator
 * @package Framewa\Auth
 */
final class Authenticator
{
    /** @var Config $authConfig */
    private Config $authConfig;

    /** @var Session $session */
    private Session $session;

    /** @var Router $router */
    private Router $router;

    /**
     * Authenticator constructor.
     */
    public function __construct()
    {
        $container = Container::createOnce();
        $this->authConfig = $container->get('framewa.config_reader')->getAuthentication();
        $this->session = $container->get('framewa.session');
        $this->router = $container->get('framewa.router');
    }

    /**
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function login(int $id): void
    {
        if (!$this->authConfig->keyExists('user_provider')) {
            
            throw new \Exception('Cannot login if "user_provider" authentication config is not defined.');
        }

        $_SESSION['user_id'] = (string) $id;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function logout(): void
    {
        $this->session->destroy();
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @return ModelInterface|null
     * @throws \Exception
     */
    public function getCurrentUser(): ?ModelInterface
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
            return null;
        }

        if (!$this->authConfig->keyExists('user_provider')) {
            return null;
        }

        $callback = $this->authConfig->get('user_provider');
        if (!is_array($callback) || !is_callable($callback)) {
            throw new \UnexpectedValueException('"user_provider" config must define a callable array.');
        }

        if (!class_exists($callback[0])) {
            throw new \UnexpectedValueException('Class "' . $callback[0] . '" does not exist in "user_provider" authentication config.');
        }

        $provider = new $callback[0];

        return $provider->{$callback[1]}((int) $_SESSION['user_id']);
    }
}
