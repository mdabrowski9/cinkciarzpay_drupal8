<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Builder;

use CKPL\Pay\Definition\Amount\AmountInterface;
use CKPL\Pay\Definition\Payment\Product\PaymentProductInterface;
use CKPL\Pay\Exception\Definition\AmountException;
use CKPL\Pay\Exception\Definition\PaymentException;

/**
 * Interface PaymentProductBuilderInterface.
 *
 * @package CKPL\Pay\Definition\Payment\Builder
 */
interface PaymentProductBuilderInterface
{
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
    public function setName(string $name): PaymentProductBuilderInterface;

    /**
     * Description.
     *
     * Min 1 character, max 100 characters.
     *
     * @param string $description
     *
     * @return PaymentProductBuilderInterface
     */
    public function setDescription(string $description): PaymentProductBuilderInterface;

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
    public function setQuantity(int $quantity): PaymentProductBuilderInterface;

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
    public function buildAmount(callable $callable): PaymentProductBuilderInterface;

    /**
     * Creates amount builder that allows to create Amount definition.
     *
     * @return AmountBuilderInterface
     */
    public function createAmountBuilder(): AmountBuilderInterface;

    /**
     * Sets Amount definition for payment.
     *
     * This value is required but can be set using `buildAmount` method too.
     *
     * @param AmountInterface $amount
     *
     * @return PaymentProductBuilderInterface
     */
    public function setAmount(AmountInterface $amount): PaymentProductBuilderInterface;

    /**
     * Returns Payment Product definition.
     *
     * @throws PaymentException if one of required parameters is missing
     *
     * @return PaymentProductInterface
     */
    public function getPaymentProduct(): PaymentProductInterface;
}
