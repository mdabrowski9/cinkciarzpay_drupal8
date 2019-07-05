<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment;

use CKPL\Pay\Definition\Amount\AmountInterface;
use CKPL\Pay\Definition\Payment\Order\PaymentOrderInterface;

/**
 * Interface PaymentInterface.
 *
 * @package CKPL\Pay\Definition\Payment
 */
interface PaymentInterface
{
    /**
     * @return string|null
     */
    public function getExternalPaymentId(): ?string;

    /**
     * @return AmountInterface|null
     */
    public function getAmount(): ?AmountInterface;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @return PaymentOrderInterface|null
     */
    public function getOrder(): ?PaymentOrderInterface;

    /**
     * @return bool|null
     */
    public function getAllowPayLater(): ?bool;

    /**
     * @return string|null
     */
    public function getReturnUrl(): ?string;

    /**
     * @return string|null
     */
    public function getErrorUrl(): ?string;

    /**
     * @return string|null
     */
    public function getNotificationUrl(): ?string;
}
