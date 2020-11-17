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

namespace Framewa\Service;

/**
 * Class Container
 * @package Framewa\Service
 */
final class Container
{
    private const SERVICES_FILEPATH = 'config/services.php';

    /** @var array<string, array<string, mixed>> $servicesConfig */
    private array $servicesConfig;

    /** @var Registry $registry */
    private Registry $registry;

    /**
     * Container constructor.
     */
    public function __construct()
    {
        if (!file_exists(self::SERVICES_FILEPATH)) {
            throw new \Exception('Could not find "config/services.php" file.');
        }
        $this->servicesConfig = require self::SERVICES_FILEPATH;

        $this->registry = new Registry();
    }

    /**
     * @return self
     */
    public static function createOnce(): self
    {
        static $container;

        if (!$container instanceof self) {
            $container = new Container();
        }

        return $container;
    }

    /**
     * @param string $name
     * @return object
     */
    public function get(string $name): object
    {
        if (($service = $this->registry->get($name)) !== null) {
            return $service;
        }

        $this->hydrate($name);

        return $this->registry->get($name);
    }

    /**
     * @param string $name
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    private function hydrate(string $name): void
    {
        if (!array_key_exists($name, $this->servicesConfig)) {
            throw new \Exception('Could not find service "' . $name . '" in "' . self::SERVICES_FILEPATH . '".');
        }

        if (!array_key_exists('class', $this->servicesConfig[$name])) {
            throw new \Exception('Service config must define the class');
        }

        if (!class_exists($this->servicesConfig[$name]['class'])) {
            throw new \Exception('Class "' . $this->servicesConfig[$name]['class'] .'" defined in services config does not exist.');
        }

        $ref = new \ReflectionClass($this->servicesConfig[$name]['class']);

        $args = $this->servicesConfig[$name]['arguments'] ?? null;
        if ($args !== null && !is_array($args)) {
            throw new \Exception('Arguments defined in services config must be of type array.');
        }

        $this->registry->add(
            $name,
            $ref->newInstance($args)
        );
    }
}
