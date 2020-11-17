<?php

declare(strict_types=1);

namespace Framewa;

use Framewa\Error\ExceptionHandler;
use Framewa\Http\Router;

/**
 * Class Kernel
 * @package Framewa
 */
class Kernel
{
    public const ENV_DEV = 'dev';
    public const ENV_TEST = 'test';
    public const ENV_PROD = 'prod';

    /** @var string $env */
    private string $env;

    /** @var Router $router */
    private Router $router;

    /**
     * Kernel constructor.
     * @param string $env
     */
    public function __construct(string $env = 'dev')
    {
        if (!in_array($env, [self::ENV_DEV, self::ENV_TEST, self::ENV_PROD], true)) {
            throw new \UnexpectedValueException("Unknown $env environment.");
        }
        $this->env = $env;

        $container = \Framewa\Service\Container::createOnce();
        $this->router = $container->get('framewa.router');
    }

    /**
     * @return void
     */
    public function handleRequest(): void
    {
        try {
            $this->router->callActionFromRequest();
        } catch (\Exception $e) {
            ExceptionHandler::handle($e, $this->env);
            die;
        }
    }

    /**
     * @return string
     */
    public function getEnv(): string
    {
        return $this->env;
    }
}
