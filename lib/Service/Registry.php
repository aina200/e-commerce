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
 * Class Registry
 * @package Framewa\Service
 */
final class Registry
{
    /** @var array<string, object> $services */
    private array $services = [];

    /**
     * @param string $name
     * @return object|null
     */
    public function get(string $name): ?object
    {
        return $this->services[$name] ?? null;
    }

    /**
     * @param string $name
     * @param object $service
     *
     * @return void
     */
    public function add(string $name, object $service): void
    {
        if (!array_key_exists($name, $this->services)) {
            $this->services[$name] = $service;
        }
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function remove(string $name): void
    {
        if (array_key_exists($name, $this->services)) {
            unset($this->services[$name]);
        }
    }
}
