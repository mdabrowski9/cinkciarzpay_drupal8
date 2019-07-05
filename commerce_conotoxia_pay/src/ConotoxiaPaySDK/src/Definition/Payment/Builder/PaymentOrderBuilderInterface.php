<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Builder;

use CKPL\Pay\Definition\Payment\Address\PaymentAddressInterface;
use CKPL\Pay\Definition\Payment\Customer\PaymentCustomerInterface;
use CKPL\Pay\Definition\Payment\Order\PaymentOrderInterface;
use CKPL\Pay\Definition\Payment\Product\PaymentProductInterface;
use CKPL\Pay\Exception\Definition\PaymentAddressException;
use CKPL\Pay\Exception\Definition\PaymentException;

/**
 * Interface PaymentOrderBuilderInterface.
 *
 * @package CKPL\Pay\Definition\Payment\Builder
 */
interface PaymentOrderBuilderInterface
{
    /**
     * Order URL in Merchant service.
     *
     * Min 1 character, max 256 characters.
     *
     * @param string $orderUrl
     *
     * @return PaymentOrderBuilderInterface
     */
    public function setOrderUrl(string $orderUrl): PaymentOrderBuilderInterface;

    /**
     * Additional information about order.
     *
     * Min 1 character, max 512 characters.
     *
     * @param string $additionalInformation
     *
     * @return PaymentOrderBuilderInterface
     */
    public function setAdditionalInformation(string $additionalInformation): PaymentOrderBuilderInterface;

    /**
     * Allows to build Payment Address definition in callable.
     *
     * Example:
     *     function (\CKPL\Pay\Definition\Payment\Builder\PaymentCustomerBuilderInterface $customerBuilder) {
     *         $customerBuilder->setFirstName('Dante');
     *         //other setters
     *     }
     *
     * @param callable $callable
     *
     * @throws PaymentException
     *
     * @return PaymentOrderBuilderInterface
     */
    public function buildCustomer(callable $callable): PaymentOrderBuilderInterface;

    /**
     * Creates customer builder that allows to create Payment Customer definition.
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function createCustomerBuilder(): PaymentCustomerBuilderInterface;

    /**
     * Sets Payment Customer definition.
     *
     * This value is required but can be set using `buildCustomer` method too.
     *
     * @param PaymentCustomerInterface $paymentCustomer
     *
     * @return PaymentOrderBuilderInterface
     */
    public function setCustomer(PaymentCustomerInterface $paymentCustomer): PaymentOrderBuilderInterface;

    /**
     * Allows to build Payment Address definition in callable.
     *
     * Example:
     *     function (\CKPL\Pay\Definition\Payment\Builder\PaymentAddressBuilderInterface $addressBuilder) {
     *         $addressBuilder->setStreet('Unknown 42');
     *         //other setters
     *     }
     *
     * @param callable $callable
     *
     * @throws PaymentAddressException
     *
     * @return PaymentOrderBuilderInterface
     */
    public function buildAddress(callable $callable): PaymentOrderBuilderInterface;

    /**
     * Creates payment address builder that allows to create Payment Address definition.
     *
     * @return PaymentAddressBuilderInterface
     */
    public function createAddressBuilder(): PaymentAddressBuilderInterface;

    /**
     * Sets Payment Address definition for payment.
     *
     * This value is required but can be set using `buildAddress` method too.
     *
     * @param PaymentAddressInterface $address
     *
     * @return PaymentOrderBuilderInterface
     */
    public function setAddress(PaymentAddressInterface $address): PaymentOrderBuilderInterface;

    /**
     * Adds Payment Product definition to order.
     *
     * @param PaymentProductInterface $paymentProduct
     *
     * @return PaymentOrderBuilderInterface
     */
    public function addProduct(PaymentProductInterface $paymentProduct): PaymentOrderBuilderInterface;

    /**
     * Creates payment product builder that allows to create Payment Product definition.
     *
     * @return PaymentProductBuilderInterface
     */
    public function createProductBuilder(): PaymentProductBuilderInterface;

    /**
     * Returns Payment Order definition.
     *
     * @return PaymentOrderInterface
     */
    public function getPaymentOrder(): PaymentOrderInterface;
}
