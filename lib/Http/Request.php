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
 * Class Request
 * @package Framewa\Request
 */
final class Request
{
    /** @var string $method */
    private string $method;

    /** @var string $pathInfo */
    private string $pathInfo;

    /** @var string $host */
    private string $host;

    /** @var string $scriptName */
    private string $scriptName;

    /** @var string $requestUri */
    private string $requestUri;

    /** @var string $protocol */
    private string $protocol;

    /** @var bool $https */
    private bool $https;

    /** @var string $fullUri */
    private string $fullUri;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->pathInfo = (function (): string {
            if (isset($_SERVER['PATH_INFO'])) {
                return $_SERVER['PATH_INFO'];
            }

            if (isset($_SERVER['BASE'])) {
                $c = 1;
                return str_replace($_SERVER['BASE'], '', $_SERVER['REQUEST_URI'], $c);
            }

            return '/';
        })();
        $this->host = $_SERVER['HTTP_HOST'];
        $this->scriptName = $_SERVER['SCRIPT_NAME'];
        $this->requestUri = $_SERVER['REQUEST_URI'];
        $this->protocol = $_SERVER['SERVER_PROTOCOL'];
        $this->https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        $this->fullUri = ($this->isHttps() ? 'https' : 'http')
            . '://'
            . $this->host
            . $this->requestUri;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPathInfo(): string
    {
        return $this->pathInfo;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getScriptName(): string
    {
        return $this->scriptName;
    }

    /**
     * @return string
     */
    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * @return bool
     */
    public function isHttps(): bool
    {
        return $this->https;
    }

    /**
     * @return string
     */
    public function getFullUri(): string
    {
        return $this->fullUri;
    }
}
