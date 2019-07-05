<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Http;

/**
 * Class HttpConflictException.
 *
 * @package CKPL\Pay\Exception\Http
 */
class HttpConflictException extends HttpException
{
    /**
     * @type int
     */
    const STATUS_CODE = 409;
}
