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

namespace Framewa\Error;

use Framewa\Kernel;

/**
 * Class ExceptionHandler
 * @package Framewa\Error
 */
final class ExceptionHandler
{
    /**
     * @param \Exception $exception
     * @param string $env
     */
    public static function handle(\Exception $exception, string $env): void
    {
        if ($env === Kernel::ENV_PROD) {
            require __DIR__ . DIRECTORY_SEPARATOR . 'error.prod.phtml';
        } else {
            require __DIR__ . DIRECTORY_SEPARATOR . 'error.dev.phtml';
        }
    }
}
