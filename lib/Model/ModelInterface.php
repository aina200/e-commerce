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

namespace Framewa\Model;

/**
 * Interface ModelInterface
 */
interface ModelInterface
{
    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function createFromArray(array $data): self;

    /**
     * @return array<int, string>
     */
    public function getValidationErrors(): array;
}
