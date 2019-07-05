<?php

declare(strict_types=1);

namespace CKPL\Pay\Refund\Status;

/**
 * Interface StatusInterface.
 *
 * @package CKPL\Pay\Refund\Status
 */
interface StatusInterface
{
    /**
     * @return string
     */
    public function getRefundId(): string;

    /**
     * @return string|null
     */
    public function getExternalRefundId(): ?string;

    /**
     * @return bool
     */
    public function isNew(): bool;

    /**
     * @return bool
     */
    public function isCompleted(): bool;

    /**
     * @return bool
     */
    public function isProcessing(): bool;
}
