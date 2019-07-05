<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Builder;

use CKPL\Pay\Definition\Payment\Address\PaymentAddressInterface;
use CKPL\Pay\Definition\Payment\Customer\PaymentCustomerInterface;
use CKPL\Pay\Exception\Definition\PaymentCustomerException;
use CKPL\Pay\Exception\Definition\PaymentException;

/**
 * Interface PaymentCustomerBuilderInterface.
 *
 * @package CKPL\Pay\Definition\Payment\Builder
 */
interface PaymentCustomerBuilderInterface
{
    /**
     * First name.
     *
     * Min 1 character, max 50 characters.
     *
     * This value is required!
     *
     * @param string $firstName
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function setFirstName(string $firstName): PaymentCustomerBuilderInterface;

    /**
     * Last name.
     *
     * Min 1 character, max 50 characters.
     *
     * This value is required!
     *
     * @param string $lastName
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function setLastName(string $lastName): PaymentCustomerBuilderInterface;

    /**
     * Company name.
     *
     * Min 1 character, max 100 characters.
     *
     * @param string $companyName
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function setCompanyName(string $companyName): PaymentCustomerBuilderInterface;

    /**
     * E-Mail address.
     *
     * Min 1 character, max 320 characters.
     *
     * This value is required!
     *
     * @param string $email
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function setEmail(string $email): PaymentCustomerBuilderInterface;

    /**
     * Phone number.
     *
     * Min 1 character, max 26 characters.
     *
     * @param string $phone
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function setPhone(string $phone): PaymentCustomerBuilderInterface;

    /**
     * Additional information about customer.
     *
     * Min 1 character, max 512 characters.
     *
     * @param string $additionalInformation
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function setAdditionalInformation(string $additionalInformation): PaymentCustomerBuilderInterface;

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
     * @throws PaymentException
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function buildAddress(callable $callable): PaymentCustomerBuilderInterface;

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
     * @param PaymentAddressInterface $paymentAddress
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function setAddress(PaymentAddressInterface $paymentAddress): PaymentCustomerBuilderInterface;

    /**
     * Returns Payment Customer definition.
     *
     * @throws PaymentCustomerException if one of required parameters is missing
     *
     * @return PaymentCustomerInterface
     */
    public function getPaymentCustomer(): PaymentCustomerInterface;
}
