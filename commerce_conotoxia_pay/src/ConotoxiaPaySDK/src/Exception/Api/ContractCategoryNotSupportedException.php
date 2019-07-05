<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api;

use CKPL\Pay\Exception\Http\HttpConflictException;

/**
 * Class ContractCategoryNotSupportedException.
 *
 * @package CKPL\Pay\Exception\Api
 */
class ContractCategoryNotSupportedException extends HttpConflictException implements ApiExceptionInterface
{
    /**
     * @type string
     */
    const TYPE = 'contract-category-not-supported';

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }
}
