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

namespace Framewa\View;

use Framewa\Auth\Authenticator;
use Framewa\Config\Config;
use Framewa\Http\Router;
use Framewa\Model\ModelInterface;
use Framewa\Service\Container;

/**
 * Class View
 * @package Framewa\View
 */
final class View
{
    private const LAYOUT_PATH = 'views/layout.phtml';

    /** @var Router $router */
    private Router $router;

    /** @var Authenticator $auth */
    private Authenticator $auth;

    /** @var ModelInterface|null $currentUser */
    private ?ModelInterface $currentUser;

    /** @var Config $parameters */
    private Config $parameters;

    /** @var string $templatePath */
    private string $templatePath;

    /** @var array<string, mixed> $data */
    private array $data;

    /**
     * View constructor.
     *
     * @param string $templatePath
     * @param array<string, mixed> $data
     *
     * @throws \Exception
     */
    public function __construct(string $templatePath, array $data = [])
    {
        if (!file_exists($templatePath)) {
            throw new \Exception('Could not find template "' . $templatePath . '".');
        }

        if (!file_exists(self::LAYOUT_PATH)) {
            throw new \Exception('views/layout.phtml must exist and require \$templatePath variable.');
        }

        $this->templatePath = $templatePath;
        $this->data = $data;

        $container = Container::createOnce();
        $this->router = $container->get('framewa.router');
        $this->auth = $container->get('framewa.authenticator');
        $this->currentUser = $this->auth->getCurrentUser();
        $this->parameters = $container->get('framewa.config_reader')->getParameters();
    }

    /**
     * @return void
     */
    public function display(): void
    {
        require self::LAYOUT_PATH;
    }

    /**
     * @param string $routeName
     * @param array<string, string> $params
     *
     * @return string
     *
     * @throws \Exception
     */
    private function generateUri(string $routeName, array $params = []): string
    {
        return $this->router->generateUri($routeName, $params);
    }
}
