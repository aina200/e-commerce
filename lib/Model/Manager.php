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

namespace Framewa\Model;

use Framewa\Service\Container;

/**
 * Class Manager
 * @package Framewa\Model
 */
abstract class Manager implements ManagerInterface
{
    /** @var \PDO $connection */
    protected \PDO $connection;

    /**
     * Manager constructor.
     */
    public function __construct()
    {
        $container = Container::createOnce();
        $this->connection = $container->get('framewa.database')->getConnection();
    }
}
