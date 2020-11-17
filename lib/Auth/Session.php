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

/**
 * Class Session
 * @package Framewa\Auth
 */
final class Session
{
    /**
     * Session constructor.
     */
    public function __construct()
    {
        $this->start();
    }

    /**
     * @return void
     */
    public function start(): void
    {
        session_start();
    }

    /**
     * @return void
     */
    public function destroy(): void
    {
        $_SESSION['user_id'] = null;
        session_destroy();
    }
}
