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

namespace Framewa\Connection;

use Framewa\Service\Container;

/**
 * Class Database
 * @package Framewa\Connection
 */
final class Database
{
    /** @var \PDO $connection */
    private \PDO $connection;

    /**
     * Database constructor.
     * @param array<string, string>|null $config
     * @throws \Exception
     */
    public function __construct(?array $config = null)
    {
        $this->initConnection($config);
    }

    /**
     * @return \PDO
     */
    public function getConnection(): \PDO
    {
        return $this->connection;
    }

    /**
     * @param array<string, string>|null $config
     *
     * @return void
     *
     * @throws \Exception
     */
    private function initConnection(?array $config = null): void
    {
        $dbConfig = $config !== null
            ? $config
            : Container::createOnce()->get('framewa.config_reader')->getDatabase()->getAll();

        if (
            !isset($dbConfig['host'])
            || !isset($dbConfig['port'])
            || !isset($dbConfig['dbname'])
            || !isset($dbConfig['username'])
            || !isset($dbConfig['password'])
        ) {
            throw new \Exception('The database config file must define "host", "port", "dbname", "username" and "password".');
        }

        $this->connection = new \PDO(
            "mysql:host={$dbConfig['host']};port={$dbConfig['port']};dbname={$dbConfig['dbname']}",
            $dbConfig['username'],
            $dbConfig['password']
        );
    }
}
