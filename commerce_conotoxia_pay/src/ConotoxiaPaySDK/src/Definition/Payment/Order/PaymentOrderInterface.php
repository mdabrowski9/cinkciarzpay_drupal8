<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Order;

use CKPL\Pay\Definition\Payment\Address\PaymentAddressInterface;
use CKPL\Pay\Definition\Payment\Customer\PaymentCustomerInterface;

/**
 * Interface PaymentOrderInterface.
 *
 * @package CKPL\Pay\Definition\Payment\Order
 */
interface PaymentOrderInterface
{
    /**
     * @return PaymentCustomerInterface|null
     */
    public function getCustomer(): ?PaymentCustomerInterface;

    /**
     * @return PaymentAddressInterface|null
     */
    public function getAddress(): ?PaymentAddressInterface;

    /**
     * @return string|null
     */
    public function getOrderUrl(): ?string;

    /**
     * @return string|null
     */
    public function getAdditionalInformation(): ?string;

    /**
     * @return array|null
     */
    public function getProducts(): ?array;
}
