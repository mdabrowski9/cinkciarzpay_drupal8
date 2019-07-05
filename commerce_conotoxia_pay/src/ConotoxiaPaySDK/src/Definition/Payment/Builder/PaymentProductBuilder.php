<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Builder;

use CKPL\Pay\Definition\Amount\AmountInterface;
use CKPL\Pay\Definition\Payment\Product\PaymentProduct;
use CKPL\Pay\Definition\Payment\Product\PaymentProductInterface;
use CKPL\Pay\Exception\Definition\AmountException;
use CKPL\Pay\Exception\Definition\PaymentException;
use CKPL\Pay\Exception\Definition\PaymentProductException;

/**
 * Class PaymentProductBuilder.
 *
 * @package CKPL\Pay\Definition\Payment\Builder
 */
class PaymentProductBuilder implements PaymentProductBuilderInterface
{
    /**
     * @var PaymentProduct
     */
    protected $paymentProduct;

    /**
     * PaymentProductBuilder constructor.
     */
    public function __construct()
    {
        $this->initializePaymentProduct();
    }

    /**
     * Name.
     *
     * Min 1 character, max 100 characters.
     *
     * This value is required!
     *
     * @param string $name
     *
     * @return PaymentProductBuilderInterface
     */
    public function setName(string $name): PaymentProductBuilderInterface
    {
        $this->paymentProduct->setName($name);

        return $this;
    }

    /**
     * Description.
     *
     * Min 1 character, max 100 characters.
     *
     * @param string $description
     *
     * @return PaymentProductBuilderInterface
     */
    public function setDescription(string $description): PaymentProductBuilderInterface
    {
        $this->paymentProduct->setDescription($description);

        return $this;
    }

    /**
     * Number of product units.
     *
     * Range from 1 to 1000000.
     *
     * This value is required!
     *
     * @param int $quantity
     *
     * @return PaymentProductBuilderInterface
     */
    public function setQuantity(int $quantity): PaymentProductBuilderInterface
    {
        $this->paymentProduct->setQuantity($quantity);

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
     * @throws AmountException
     *
     * @return PaymentProductBuilderInterface
     */
    public function buildAmount(callable $callable): PaymentProductBuilderInterface
    {
        $amountBuilder = new AmountBuilder();
        \call_user_func($callable, $amountBuilder);

        $this->paymentProduct->setAmount($amountBuilder->getAmount());

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
     * @return PaymentProductBuilderInterface
     */
    public function setAmount(AmountInterface $amount): PaymentProductBuilderInterface
    {
        $this->paymentProduct->setAmount($amount);

        return $this;
    }

    /**
     * Returns Payment Product definition.
     *
     * @throws PaymentException if one of required parameters is missing
     *
     * @return PaymentProductInterface
     */
    public function getPaymentProduct(): PaymentProductInterface
    {
        if (null === $this->paymentProduct->getAmount()) {
            throw new PaymentProductException('Missing amount in payment product.');
        }

        if (empty($this->paymentProduct->getName())) {
            throw new PaymentProductException('Missing name in payment product.');
        }

        if (null === $this->paymentProduct->getQuantity() || $this->paymentProduct->getQuantity() < 0) {
            throw new PaymentProductException('Missing quantity in payment product.');
        }

        return $this->paymentProduct;
    }

    /**
     * @return void
     */
    protected function initializePaymentProduct(): void
    {
        $this->paymentProduct = new PaymentProduct();
    }
}
