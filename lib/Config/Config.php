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
 * Class Config
 * @package Framewa\Config
 */
final class Config
{
    /** @var string $filepath */
    private string $filepath;

    /** @var array<string, mixed> $entries */
    private array $entries;

    /**
     * Config constructor.
     * @param string $filepath
     */
    public function __construct(string $filepath)
    {
        if (!file_exists($filepath)) {
            throw new \Exception('Could not find config file "' . $filepath . '".');
        }

        $this->filepath = $filepath;

        $this->entries = require $filepath;

        if (!is_array($this->entries)) {
            throw new \Exception('Config file "' . $filepath . '" must return an array.');
        }
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        if (!array_key_exists($key, $this->entries)) {
            throw new \Exception('Could not find key "' . $key . '" in file "' . $this->filepath . '".');
        }

        return $this->entries[$key];
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function keyExists(string $key): bool
    {
        return array_key_exists($key, $this->entries);
    }

    /**
     * @return array<string, mixed>
     */
    public function getAll(): array
    {
        return $this->entries;
    }
}
