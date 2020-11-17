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

namespace Framewa\Http;

/**
 * Class Router
 * @package Framewa\Router
 */
final class Router
{
    /** @var Request $request */
    private Request $request;

    /** @var array<string, array> $routes */
    private array $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->routes = require 'config/routes.php';
    }

    /**
     * Find and call the right action in the right Controller, based on
     * HTTP request's path and routes definitions.
     *
     * Multiple errors can occur there if routes are note defined correctly.
     *
     * @return void
     *
     * @throws \Exception
     *
     * @todo Better handling for default route. Or 404?
     */
    public function callActionFromRequest(): void
    {
        $pathInfo = $this->request->getPathInfo();
        $paramsPosition = strpos($pathInfo, '?');
        if ($paramsPosition !== false) {
            $pathInfo = substr($pathInfo, 0, $paramsPosition);
        }

        if (!isset($this->routes[$pathInfo]) && !isset($this->routes['/'])) {
            throw new \Exception('The "routes.php" file must at least define a "/" route.');
        }

        $route = $this->routes[$pathInfo] ?? $this->routes['/'];

        if (!isset($route['name']) || !isset($route['action'])) {
            throw new \Exception('Each route in the "routes.php" file must define a "name" and an "action".');
        }

        if (!is_array($route['action']) || !is_callable($route['action'])) {
            throw new \Exception('Route\'s action must be a callable array.');
        }

        if (!class_exists($route['action'][0])) {
            throw new \Exception('Class "' . $route['action'][0] . '" does not exist in "' . $route['name'] . '" route\'s definition.');
        }

        $controller = new $route['action'][0];
        $controller->{$route['action'][1]}();
    }

    /**
     * @param string $name
     * @param array<string, mixed> $params
     *
     * @return string
     *
     * @throws \Exception
     */
    public function generateUri(string $name, array $params = []): string
    {
        $uri = null;

        // Guessing base URI from route name
        foreach ($this->routes as $path => $route) {
            if ($route['name'] === $name) {
                $c = 1;
                $uri = str_replace(
                    '/index.php', '', $this->request->getScriptName(), $c
                )
                . rtrim($path, '/');
                break;
            }
        }

        if ($uri === null) {
            throw new \Exception('Route with name "' . $name . '" does not exist.');
        }

        // Appending GET parameters
        if (!empty($params)) {
            array_walk($params, function(&$val, $key) {
                $val = urlencode((string) $key) . '=' . urlencode((string) $val);
            });
            $uri .= '?' . implode('&', $params);
        }

        return $uri;
    }

    /**
     * @param string $name
     * @param array<string, string> $params
     *
     * @throws \Exception
     *
     * @return void
     */
    public function redirectToRoute(string $name, array $params = []): void
    {
        $uri = $this->generateUri($name, $params);
        header("Location: $uri");
        die;
    }
}
