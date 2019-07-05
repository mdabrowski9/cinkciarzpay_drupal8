<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Customer;

use CKPL\Pay\Definition\Payment\Address\PaymentAddressInterface;

/**
 * Interface PaymentCustomerInterface.
 *
 * @package CKPL\Pay\Definition\Payment\Customer
 */
interface PaymentCustomerInterface
{
    /**
     * @return string|null
     */
    public function getFirstName(): ?string;

    /**
     * @return string|null
     */
    public function getLastName(): ?string;

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string;

    /**
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * @return string|null
     */
    public function getPhone(): ?string;

    /**
     * @return PaymentAddressInterface|null
     */
    public function getAddress(): ?PaymentAddressInterface;

    /**
     * @return string|null
     */
    public function getAdditionalInformation(): ?string;
}
