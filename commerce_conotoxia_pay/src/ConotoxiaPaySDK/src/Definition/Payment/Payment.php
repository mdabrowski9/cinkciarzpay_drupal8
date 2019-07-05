<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment;

use CKPL\Pay\Definition\Amount\AmountInterface;
use CKPL\Pay\Definition\Payment\Order\PaymentOrderInterface;

/**
 * Class Payment.
 *
 * @package CKPL\Pay\Definition\Payment
 */
class Payment implements PaymentInterface
{
    /**
     * @var string|null
     */
    protected $externalPaymentId;

    /**
     * @var AmountInterface|null
     */
    protected $amount;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @var PaymentOrderInterface|null
     */
    protected $order;

    /**
     * @var bool|null
     */
    protected $allowPayLater;

    /**
     * @var string|null
     */
    protected $returnUrl;

    /**
     * @var string|null
     */
    protected $errorUrl;

    /**
     * @var string|null
     */
    protected $notificationUrl;

    /**
     * @return string|null
     */
    public function getExternalPaymentId(): ?string
    {
        return $this->externalPaymentId;
    }

    /**
     * @param string $externalPaymentId
     *
     * @return Payment
     */
    public function setExternalPaymentId(string $externalPaymentId): Payment
    {
        $this->externalPaymentId = $externalPaymentId;

        return $this;
    }

    /**
     * @return AmountInterface|null
     */
    public function getAmount(): ?AmountInterface
    {
        return $this->amount;
    }

    /**
     * @param AmountInterface $amount
     *
     * @return Payment
     */
    public function setAmount(AmountInterface $amount): Payment
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Payment
     */
    public function setDescription(?string $description): Payment
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return PaymentOrderInterface|null
     */
    public function getOrder(): ?PaymentOrderInterface
    {
        return $this->order;
    }

    /**
     * @param PaymentOrderInterface $order
     *
     * @return Payment
     */
    public function setOrder(PaymentOrderInterface $order): Payment
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAllowPayLater(): ?bool
    {
        return $this->allowPayLater;
    }

    /**
     * @param bool $allowPayLater
     *
     * @return Payment
     */
    public function setAllowPayLater(bool $allowPayLater): Payment
    {
        $this->allowPayLater = $allowPayLater;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getReturnUrl(): ?string
    {
        return $this->returnUrl;
    }

    /**
     * @param string|null $returnUrl
     *
     * @return Payment
     */
    public function setReturnUrl(string $returnUrl = null): Payment
    {
        $this->returnUrl = $returnUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getErrorUrl(): ?string
    {
        return $this->errorUrl;
    }

    /**
     * @param string|null $errorUrl
     *
     * @return Payment
     */
    public function setErrorUrl(string $errorUrl = null): Payment
    {
        $this->errorUrl = $errorUrl;

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
     * @return Payment
     */
    public function setNotificationUrl(string $notificationUrl = null): Payment
    {
        $this->notificationUrl = $notificationUrl;

        return $this;
    }
}
