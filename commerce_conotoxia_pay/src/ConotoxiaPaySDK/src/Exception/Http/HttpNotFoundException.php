<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Http;

/**
 * Class HttpNotFoundException.
 *
 * @package CKPL\Pay\Exception\Http
 */
class HttpNotFoundException extends HttpException
{
    /**
     * @type int
     */
    const STATUS_CODE = 404;
}
