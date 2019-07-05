<?php

declare(strict_types=1);

namespace CKPL\Pay\Payment\Status;

/**
 * Class Status.
 *
 * @package CKPL\Pay\Payment\Status
 */
class Status implements StatusInterface
{
    /**
     * @var string
     */
    protected $paymentId;

    /**
     * @var string
     */
    protected $externalPaymentId;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @type string
     */
    const PAYMENT_STATUS_NEW = 'NEW';

    /**
     * @type string
     */
    const PAYMENT_STATUS_COMPLETED = 'COMPLETED';

    /**
     * @type string
     */
    const PAYMENT_STATUS_CANCELLED = 'CANCELLED';

    /**
     * @type string
     */
    const PAYMENT_STATUS_REJECTED = 'REJECTED';

    /**
     * Status constructor.
     *
     * @param string      $paymentId
     * @param string      $externalPaymentId
     * @param string      $code
     * @param string|null $description
     */
    public function __construct(string $paymentId, string $externalPaymentId, string $code, string $description = null)
    {
        $this->paymentId = $paymentId;
        $this->externalPaymentId = $externalPaymentId;
        $this->code = $code;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    /**
     * @return string
     */
    public function getExternalPaymentId(): string
    {
        return $this->externalPaymentId;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->code === static::PAYMENT_STATUS_NEW;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->code === static::PAYMENT_STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->code === static::PAYMENT_STATUS_CANCELLED;
    }

    /**
     * @return bool
     */
    public function isRejected(): bool
    {
        return $this->code === static::PAYMENT_STATUS_REJECTED;
    }
}
