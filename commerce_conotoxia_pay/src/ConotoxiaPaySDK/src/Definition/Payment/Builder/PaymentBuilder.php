<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Builder;

use CKPL\Pay\Definition\Amount\AmountInterface;
use CKPL\Pay\Definition\Payment\Order\PaymentOrderInterface;
use CKPL\Pay\Definition\Payment\Payment;
use CKPL\Pay\Definition\Payment\PaymentInterface;
use CKPL\Pay\Exception\Definition\PaymentException;

/**
 * Class PaymentBuilder.
 *
 * @package CKPL\Pay\Definition\Payment\Builder
 */
class PaymentBuilder implements PaymentBuilderInterface
{
    /**
     * @var Payment
     */
    protected $payment;

    /**
     * PaymentBuilder constructor.
     */
    public function __construct()
    {
        $this->initializePayment();
    }

    /**
     * External payment ID.
     *
     * This ID should be generated by service where
     * library is implemented in. Could be internal payment
     * system ID or shop order ID.
     *
     * Min 1 character, max 36 characters.
     *
     * This value is required!
     *
     * @param string $externalPaymentId
     *
     * @return PaymentBuilderInterface
     */
    public function setExternalPaymentId(string $externalPaymentId): PaymentBuilderInterface
    {
        $this->payment->setExternalPaymentId($externalPaymentId);

        return $this;
    }

    /**
     * Description.
     *
     * Min 1 character, max 128 characters.
     *
     * This value is required!
     *
     * @param string $description
     *
     * @return PaymentBuilderInterface
     */
    public function setDescription(string $description): PaymentBuilderInterface
    {
        $this->payment->setDescription($description);

        return $this;
    }

    /**
     * Notification URL.
     *
     * Payment Service will send information about
     * the course of the transaction to this URL.
     *
     * Value is not required.
     * Can be set in Merchant panel or as a global value in configuration.
     *
     * Min 1 character, max 256 characters.
     *
     * @param string $notificationUrl
     *
     * @return PaymentBuilderInterface
     */
    public function setNotificationUrl(string $notificationUrl): PaymentBuilderInterface
    {
        $this->payment->setNotificationUrl($notificationUrl);

        return $this;
    }

    /**
     * Error URL.
     *
     * Payment Service will redirect client to this
     * URL on transaction failure.
     *
     * Value is not required.
     * Can be set in Merchant panel or as a global value in configuration.
     *
     * Min 1 character, max 256 characters.
     *
     * @param string $errorUrl
     *
     * @return PaymentBuilderInterface
     */
    public function setErrorUrl(string $errorUrl): PaymentBuilderInterface
    {
        $this->payment->setErrorUrl($errorUrl);

        return $this;
    }

    /**
     * Return URL.
     *
     * Payment Service will redirect client to this
     * URL if transaction succeeded.
     *
     * Value is not required.
     * Can be set in Merchant panel or as a global value in configuration.
     *
     * Min 1 character, max 256 characters.
     *
     * @param string $returnUrl
     *
     * @return PaymentBuilderInterface
     */
    public function setReturnUrl(string $returnUrl): PaymentBuilderInterface
    {
        $this->payment->setReturnUrl($returnUrl);

        return $this;
    }

    /**
     * Enables the "pay later" function for this payment.
     *
     * @return PaymentBuilderInterface
     */
    public function allowPayLater(): PaymentBuilderInterface
    {
        $this->payment->setAllowPayLater(true);

        return $this;
    }

    /**
     * Disables the "pay later" function for this payment.
     *
     * @return PaymentBuilderInterface
     */
    public function denyPayLater(): PaymentBuilderInterface
    {
        $this->payment->setAllowPayLater(false);

        return $this;
    }

    /**
     * Allows to build Amount definition in callable.
     *
     * Example:
     *     function (\CKPL\Pay\Definition\Payment\Builder\AmountBuilderInterface $amountBuilder) {
     *         $amountBuilder->setAmount('12.30')
     *         //other setters
     *     }
     *
     * @param callable $callable
     *
     * @throws PaymentException on builder failure
     *
     * @return PaymentBuilderInterface
     */
    public function buildAmount(callable $callable): PaymentBuilderInterface
    {
        $amountBuilder = new AmountBuilder();
        \call_user_func($callable, $amountBuilder);

        $this->payment->setAmount($amountBuilder->getAmount());

        return $this;
    }

    /**
     * Creates amount builder that allows to create Amount definition.
     *
     * @return AmountBuilderInterface
     */
    public function createAmountBuilder(): AmountBuilderInterface
    {
        return new AmountBuilder();
    }

    /**
     * Sets Amount definition for payment.
     *
     * This value is required but can be set using `buildAmount` method too.
     *
     * @param AmountInterface $amount
     *
     * @return PaymentBuilderInterface
     */
    public function setAmount(AmountInterface $amount): PaymentBuilderInterface
    {
        $this->payment->setAmount($amount);

        return $this;
    }

    /**
     * Allows to build Order definition in callable.
     *
     * Example:
     *     function (\CKPL\Pay\Definition\Payment\Builder\PaymentOrderBuilder $orderBuilder) {
     *          $orderBuilder->setAdditionalInformation('stuff');
     *          //other setters
     *     }
     *
     * @param callable $callable
     *
     * @return PaymentBuilderInterface
     */
    public function buildOrder(callable $callable): PaymentBuilderInterface
    {
        $orderBuilder = new PaymentOrderBuilder();
        \call_user_func($callable, $orderBuilder);

        $this->payment->setOrder($orderBuilder->getPaymentOrder());

        return $this;
    }

    /**
     * Creates order builder that allows to create Payment Order definition.
     *
     * @return PaymentOrderBuilderInterface
     */
    public function createOrderBuilder(): PaymentOrderBuilderInterface
    {
        return new PaymentOrderBuilder();
    }

    /**
     * Sets Payment Order definition for payment.
     *
     * This value is required but can be set using `buildOrder` method too.
     *
     * @param PaymentOrderInterface $paymentOrder
     *
     * @return PaymentBuilderInterface
     */
    public function setOrder(PaymentOrderInterface $paymentOrder): PaymentBuilderInterface
    {
        $this->payment->setOrder($paymentOrder);

        return $this;
    }

    /**
     * Returns Payment definition.
     *
     * @throws PaymentException if one of required parameters is missing
     *
     * @return PaymentInterface
     */
    public function getPayment(): PaymentInterface
    {
        if (null === $this->payment->getAmount()) {
            throw new PaymentException('Missing amount in payment.');
        }

        if (empty($this->payment->getDescription())) {
            throw new PaymentException('Missing description in payment.');
        }

        if (empty($this->payment->getExternalPaymentId())) {
            throw new PaymentException('Missing external payment ID in payment.');
        }

        return $this->payment;
    }

    /**
     * @return void
     */
    protected function initializePayment(): void
    {
        $this->payment = new Payment();
    }
}
