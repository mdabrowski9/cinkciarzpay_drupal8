<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Builder;

use CKPL\Pay\Definition\Payment\Address\PaymentAddressInterface;
use CKPL\Pay\Definition\Payment\Customer\PaymentCustomer;
use CKPL\Pay\Definition\Payment\Customer\PaymentCustomerInterface;
use CKPL\Pay\Exception\Definition\PaymentCustomerException;
use CKPL\Pay\Exception\Definition\PaymentException;

/**
 * Class PaymentCustomerBuilder.
 *
 * @package CKPL\Pay\Definition\Payment\Builder
 */
class PaymentCustomerBuilder implements PaymentCustomerBuilderInterface
{
    /**
     * @var PaymentCustomer
     */
    protected $paymentCustomer;

    /**
     * PaymentCustomerBuilder constructor.
     */
    public function __construct()
    {
        $this->initializePaymentCustomer();
    }

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
    public function setFirstName(string $firstName): PaymentCustomerBuilderInterface
    {
        $this->paymentCustomer->setFirstName($firstName);

        return $this;
    }

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
    public function setLastName(string $lastName): PaymentCustomerBuilderInterface
    {
        $this->paymentCustomer->setLastName($lastName);

        return $this;
    }

    /**
     * Company name.
     *
     * Min 1 character, max 100 characters.
     *
     * @param string $companyName
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function setCompanyName(string $companyName): PaymentCustomerBuilderInterface
    {
        $this->paymentCustomer->setCompanyName($companyName);

        return $this;
    }

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
    public function setEmail(string $email): PaymentCustomerBuilderInterface
    {
        $this->paymentCustomer->setEmail($email);

        return $this;
    }

    /**
     * Phone number.
     *
     * Min 1 character, max 26 characters.
     *
     * @param string $phone
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function setPhone(string $phone): PaymentCustomerBuilderInterface
    {
        $this->paymentCustomer->setPhone($phone);

        return $this;
    }

    /**
     * Additional information about customer.
     *
     * Min 1 character, max 512 characters.
     *
     * @param string $additionalInformation
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function setAdditionalInformation(string $additionalInformation): PaymentCustomerBuilderInterface
    {
        $this->paymentCustomer->setAdditionalInformation($additionalInformation);

        return $this;
    }

    /**
     * Allows to build Payment Address definition in callable.
     *
     * Example:
     *     function (\CKPL\Pay\Definition\Payment\Builder\PaymentAddressBuilderInterface $addressBuilder) {
     *         $addressBuilder->setStreet('Unknown 42')
     *         //other setters
     *     }
     *
     * @param callable $callable
     *
     * @throws PaymentException
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function buildAddress(callable $callable): PaymentCustomerBuilderInterface
    {
        $addressBuilder = new PaymentAddressBuilder();
        \call_user_func($callable, $addressBuilder);

        $this->paymentCustomer->setAddress($addressBuilder->getPaymentAddress());

        return $this;
    }

    /**
     * Creates payment address builder that allows to create Payment Address definition.
     *
     * @return PaymentAddressBuilderInterface
     */
    public function createAddressBuilder(): PaymentAddressBuilderInterface
    {
        return new PaymentAddressBuilder();
    }

    /**
     * Sets Payment Address definition for payment.
     *
     * This value is required but can be set using `buildAddress` method too.
     *
     * @param PaymentAddressInterface $paymentAddress
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function setAddress(PaymentAddressInterface $paymentAddress): PaymentCustomerBuilderInterface
    {
        $this->paymentCustomer->setAddress($paymentAddress);

        return $this;
    }

    /**
     * Returns Payment Customer definition.
     *
     * @throws PaymentCustomerException if one of required parameters is missing
     *
     * @return PaymentCustomerInterface
     */
    public function getPaymentCustomer(): PaymentCustomerInterface
    {
        if (empty($this->paymentCustomer->getFirstName())) {
            throw new PaymentCustomerException('Missing first name for payment customer.');
        }

        if (empty($this->paymentCustomer->getLastName())) {
            throw new PaymentCustomerException('Missing last name for payment customer.');
        }

        if (empty($this->paymentCustomer->getEmail())) {
            throw new PaymentCustomerException('Missing email name for payment customer.');
        }

        return $this->paymentCustomer;
    }

    /**
     * @return void
     */
    protected function initializePaymentCustomer(): void
    {
        $this->paymentCustomer = new PaymentCustomer();
    }
}
