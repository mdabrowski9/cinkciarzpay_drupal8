<?php

declare(strict_types=1);

namespace CKPL\Pay\Payment\Status;

/**
 * Interface StatusInterface.
 *
 * @package CKPL\Pay\Payment\Status
 */
interface StatusInterface
{
    /**
     * @return string
     */
    public function getPaymentId(): string;

    /**
     * @return string
     */
    public function getExternalPaymentId(): string;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

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
    public function isCancelled(): bool;

    /**
     * @return bool
     */
    public function isRejected(): bool;
}
