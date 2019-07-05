<?php

declare(strict_types=1);

namespace CKPL\Pay\Refund\Status;

/**
 * Class Status.
 *
 * @package CKPL\Pay\Refund\Status
 */
class Status implements StatusInterface
{
    /**
     * @var string
     */
    protected $refundId;

    /**
     * @var string|null
     */
    protected $externalRefundId;

    /**
     * @var string
     */
    protected $code;

    /**
     * @type string
     */
    const REFUND_STATUS_NEW = 'NEW';

    /**
     * @type string
     */
    const REFUND_STATUS_COMPLETED = 'COMPLETED';

    /**
     * @type string
     */
    const REFUND_STATUS_PROCESSING = 'PROCESSING';

    /**
     * Status constructor.
     *
     * @param string $refundId
     * @param string $code
     * @param string $externalRefundId
     */
    public function __construct(string $refundId, string $code, string $externalRefundId = null)
    {
        $this->refundId = $refundId;
        $this->code = $code;
        $this->externalRefundId = $externalRefundId;
    }

    /**
     * @return string
     */
    public function getRefundId(): string
    {
        return $this->refundId;
    }

    /**
     * @return string|null
     */
    public function getExternalRefundId(): ?string
    {
        return $this->externalRefundId;
    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->code === static::REFUND_STATUS_NEW;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->code === static::REFUND_STATUS_COMPLETED;
    }

    /**
     * @return bool
     */
    public function isProcessing(): bool
    {
        return $this->code === static::REFUND_STATUS_PROCESSING;
    }
}
