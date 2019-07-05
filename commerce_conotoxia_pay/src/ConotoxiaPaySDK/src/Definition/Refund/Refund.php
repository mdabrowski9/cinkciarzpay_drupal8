<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Refund;

/**
 * Class Refund.
 *
 * @package CKPL\Pay\Definition\Refund
 */
class Refund implements RefundInterface
{
    /**
     * @var string|null
     */
    protected $paymentId;

    /**
     * @var string|null
     */
    protected $reason;

    /**
     * @var string|null
     */
    protected $externalRefundId;

    /**
     * @var string|null
     */
    protected $value;

    /**
     * @var string|null
     */
    protected $currency;

    /**
     * @var string|null
     */
    protected $notificationUrl;

    /**
     * @return string|null
     */
    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    /**
     * @param string|null $paymentId
     *
     * @return Refund
     */
    public function setPaymentId(string $paymentId = null): Refund
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }

    /**
     * @param string|null $reason
     *
     * @return Refund
     */
    public function setReason(string $reason = null): Refund
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalRefundId(): ?string
    {
        return $this->externalRefundId;
    }

    /**
     * @param string|null $externalRefundId
     *
     * @return Refund
     */
    public function setExternalRefundId(string $externalRefundId = null): Refund
    {
        $this->externalRefundId = $externalRefundId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     *
     * @return Refund
     */
    public function setValue(string $value = null): Refund
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @param string|null $currency
     *
     * @return Refund
     */
    public function setCurrency(string $currency = null): Refund
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNotificationUrl(): ?string
    {
        return $this->notificationUrl;
    }

    /**
     * @param string|null $notificationUrl
     *
     * @return Refund
     */
    public function setNotificationUrl(string $notificationUrl = null): Refund
    {
        $this->notificationUrl = $notificationUrl;

        return $this;
    }
}
