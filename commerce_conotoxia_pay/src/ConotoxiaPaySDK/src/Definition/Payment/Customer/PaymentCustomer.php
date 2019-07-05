<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Customer;

use CKPL\Pay\Definition\Payment\Address\PaymentAddressInterface;

/**
 * Class PaymentCustomer.
 *
 * @package CKPL\Pay\Definition\Payment\Customer
 */
class PaymentCustomer implements PaymentCustomerInterface
{
    /**
     * @var string|null
     */
    protected $firstName;

    /**
     * @var string|null
     */
    protected $lastName;

    /**
     * @var string|null
     */
    protected $companyName;

    /**
     * @var string|null
     */
    protected $email;

    /**
     * @var string|null
     */
    protected $phone;

    /**
     * @var PaymentAddressInterface|null
     */
    protected $address;

    /**
     * @var string|null
     */
    protected $additionalInformation;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     *
     * @return PaymentCustomer
     */
    public function setFirstName(string $firstName): PaymentCustomer
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return PaymentCustomer
     */
    public function setLastName(string $lastName): PaymentCustomer
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     *
     * @return PaymentCustomer
     */
    public function setCompanyName(string $companyName): PaymentCustomer
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return PaymentCustomer
     */
    public function setEmail(string $email): PaymentCustomer
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return PaymentCustomer
     */
    public function setPhone(string $phone): PaymentCustomer
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return PaymentAddressInterface|null
     */
    public function getAddress(): ?PaymentAddressInterface
    {
        return $this->address;
    }

    /**
     * @param PaymentAddressInterface $address
     *
     * @return PaymentCustomer
     */
    public function setAddress(PaymentAddressInterface $address): PaymentCustomer
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    /**
     * @param string $additionalInformation
     *
     * @return PaymentCustomer
     */
    public function setAdditionalInformation(string $additionalInformation): PaymentCustomer
    {
        $this->additionalInformation = $additionalInformation;

        return $this;
    }
}
