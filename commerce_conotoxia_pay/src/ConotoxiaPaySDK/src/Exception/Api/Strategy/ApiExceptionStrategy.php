<?php

declare(strict_types=1);

namespace CKPL\Pay\Exception\Api\Strategy;

use CKPL\Pay\Definition\Payload\PayloadInterface;
use CKPL\Pay\Exception\Api\ApiExceptionInterface;
use CKPL\Pay\Exception\Api\ContractCategoryNotSupportedException;
use CKPL\Pay\Exception\Api\InvalidPemException;
use CKPL\Pay\Exception\Api\PaymentMoneyBelowLimitException;
use CKPL\Pay\Exception\Api\PaymentNotCompletedException;
use CKPL\Pay\Exception\Api\PointOfSaleCurrencyNotSupportedException;
use CKPL\Pay\Exception\Api\PointOfSaleDeletedException;
use CKPL\Pay\Exception\Api\PointOfSaleForbiddenErrorUrlException;
use CKPL\Pay\Exception\Api\PointOfSaleForbiddenNotificationUrlException;
use CKPL\Pay\Exception\Api\PointOfSaleForbiddenReturnUrlException;
use CKPL\Pay\Exception\Api\PointOfSaleNotActiveException;
use CKPL\Pay\Exception\Api\PointOfSaleNotFoundException;
use CKPL\Pay\Exception\Api\RefundAmountTooLargeException;
use CKPL\Pay\Exception\Api\RefundIncorrectCurrencyCodeException;
use CKPL\Pay\Exception\Api\StoreNotFoundException;
use CKPL\Pay\Exception\Api\TransactionLimitExceedException;
use CKPL\Pay\Exception\Api\UnknownApiErrorException;
use CKPL\Pay\Exception\Api\ValidationErrorException;
use CKPL\Pay\Exception\PayloadException;

/**
 * Class ApiExceptionStrategy.
 *
 * @package CKPL\Pay\Exception\Api\Strategy
 */
class ApiExceptionStrategy implements ApiExceptionStrategyInterface
{
    /**
     * @var string|null
     */
    protected $type;
    /**
     * @var PayloadInterface
     */
    protected $payload;

    /**
     * ApiExceptionStrategy constructor.
     *
     * @param PayloadInterface $payload
     *
     * @throws PayloadException
     */
    public function __construct(PayloadInterface $payload)
    {
        if ($payload->hasElement('type')) {
            $this->type = $payload->expectStringOrNull('type');
        }

        $this->payload = $payload;
    }

    /**
     * @return bool
     */
    public function isApi(): bool
    {
        return null !== $this->type;
    }

    /**
     * @throws PayloadException
     *
     * @return ApiExceptionInterface
     */
    public function getException(): ApiExceptionInterface
    {
        $title = $this->payload->hasElement('title') ? $this->payload->expectStringOrNull('title') : 'Error';
        $detail = $this->payload->hasElement('detail') ? $this->payload->expectStringOrNull('detail') : 'UNKNOWN';

        switch ($this->type) {
            case InvalidPemException::TYPE:
                $exception = new InvalidPemException($title, $detail);
                break;
            case ValidationErrorException::TYPE:
                $exception = new ValidationErrorException($title, $detail);
                $validationCollection = $exception->createValidationCollection();

                foreach ($this->payload->expectArrayOrNull('validation-errors') as $error) {
                    $validationCollection->addError($error['message-key'], $error['context-key'], $error['message']);
                }

                break;
            case PointOfSaleNotFoundException::TYPE:
                $exception = new PointOfSaleNotFoundException($title, $detail);
                break;
            case StoreNotFoundException::TYPE:
                $exception = new StoreNotFoundException($title, $detail);
                break;
            case ContractCategoryNotSupportedException::TYPE:
                $exception = new ContractCategoryNotSupportedException($title, $detail);
                break;
            case PaymentMoneyBelowLimitException::TYPE:
                $exception = new PaymentMoneyBelowLimitException($title, $detail);
                break;
            case PaymentNotCompletedException::TYPE:
                $exception = new PaymentNotCompletedException($title, $detail);
                break;
            case PointOfSaleCurrencyNotSupportedException::TYPE:
                $exception = new PointOfSaleCurrencyNotSupportedException($title, $detail);
                break;
            case PointOfSaleDeletedException::TYPE:
                $exception = new PointOfSaleDeletedException($title, $detail);
                break;
            case PointOfSaleForbiddenErrorUrlException::TYPE:
                $exception = new PointOfSaleForbiddenErrorUrlException($title, $detail);
                break;
            case PointOfSaleForbiddenNotificationUrlException::TYPE:
                $exception = new PointOfSaleForbiddenNotificationUrlException($title, $detail);
                break;
            case PointOfSaleForbiddenReturnUrlException::TYPE:
                $exception = new PointOfSaleForbiddenReturnUrlException($title, $detail);
                break;
            case PointOfSaleNotActiveException::TYPE:
                $exception = new PointOfSaleNotActiveException($title, $detail);
                break;
            case RefundAmountTooLargeException::TYPE:
                $exception = new RefundAmountTooLargeException($title, $detail);
                break;
            case RefundIncorrectCurrencyCodeException::TYPE:
                $exception = new RefundIncorrectCurrencyCodeException($title, $detail);
                break;
            case TransactionLimitExceedException::TYPE:
                $exception = new TransactionLimitExceedException($title, $detail);
                break;
            default:
                $exception = new UnknownApiErrorException('Unknown API exception type', $this->type);
                break;
        }

        return $exception;
    }
}
