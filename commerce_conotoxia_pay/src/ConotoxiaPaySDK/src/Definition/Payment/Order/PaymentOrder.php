<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Order;

use CKPL\Pay\Definition\Payment\Address\PaymentAddressInterface;
use CKPL\Pay\Definition\Payment\Customer\PaymentCustomerInterface;
use CKPL\Pay\Definition\Payment\Product\PaymentProductInterface;

/**
 * Class PaymentOrder.
 *
 * @package CKPL\Pay\Definition\Payment\Order
 */
class PaymentOrder implements PaymentOrderInterface
{
    /**
     * @var PaymentCustomerInterface|null
     */
    protected $customer;

    /**
     * @var PaymentAddressInterface|null
     */
    protected $address;

    /**
     * @var string|null
     */
    protected $orderUrl;

    /**
     * @var string|null
     */
    protected $additionalInformation;

    /**
     * @var array|PaymentProductInterface[]|null
     */
    protected $products;

    /**
     * @return PaymentCustomerInterface|null
     */
    public function getCustomer(): ?PaymentCustomerInterface
    {
        return $this->customer;
    }

    /**
     * @param PaymentCustomerInterface $customer
     *
     * @return PaymentOrder
     */
    public function setCustomer(PaymentCustomerInterface $customer): PaymentOrder
    {
        $this->customer = $customer;

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
     * @return PaymentOrder
     */
    public function setAddress(PaymentAddressInterface $address): PaymentOrder
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderUrl(): ?string
    {
        return $this->orderUrl;
    }

    /**
     * @param string $orderUrl
     *
     * @return PaymentOrder
     */
    public function setOrderUrl(string $orderUrl): PaymentOrder
    {
        $this->orderUrl = $orderUrl;

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
     * @return PaymentOrder
     */
    public function setAdditionalInformation(string $additionalInformation): PaymentOrder
    {
        $this->additionalInformation = $additionalInformation;

        return $this;
    }

    /**
     * @return array|PaymentProductInterface[]|null
     */
    public function getProducts(): ?array
    {
        return $this->products;
    }

    /**
     * @param array|PaymentProductInterface[] $products
     *
     * @return PaymentOrder
     */
    public function setProducts(array $products): PaymentOrder
    {
        $this->products = $products;

        return $this;
    }
}
