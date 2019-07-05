<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Builder;

use CKPL\Pay\Definition\Payment\Address\PaymentAddressInterface;
use CKPL\Pay\Definition\Payment\Customer\PaymentCustomerInterface;
use CKPL\Pay\Definition\Payment\Order\PaymentOrder;
use CKPL\Pay\Definition\Payment\Order\PaymentOrderInterface;
use CKPL\Pay\Definition\Payment\Product\PaymentProductInterface;
use CKPL\Pay\Exception\Definition\PaymentAddressException;
use CKPL\Pay\Exception\Definition\PaymentException;

/**
 * Class PaymentOrderBuilder.
 *
 * @package CKPL\Pay\Definition\Payment\Builder
 */
class PaymentOrderBuilder implements PaymentOrderBuilderInterface
{
    /**
     * @var PaymentOrder
     */
    protected $paymentOrder;

    /**
     * PaymentOrderBuilder constructor.
     */
    public function __construct()
    {
        $this->initializePaymentOrder();
    }

    /**
     * Order URL in Merchant service.
     *
     * Min 1 character, max 256 characters.
     *
     * @param string $orderUrl
     *
     * @return PaymentOrderBuilderInterface
     */
    public function setOrderUrl(string $orderUrl): PaymentOrderBuilderInterface
    {
        $this->paymentOrder->setOrderUrl($orderUrl);

        return $this;
    }

    /**
     * Additional information about order.
     *
     * Min 1 character, max 512 characters.
     *
     * @param string $additionalInformation
     *
     * @return PaymentOrderBuilderInterface
     */
    public function setAdditionalInformation(string $additionalInformation): PaymentOrderBuilderInterface
    {
        $this->paymentOrder->setAdditionalInformation($additionalInformation);

        return $this;
    }

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
    public function buildCustomer(callable $callable): PaymentOrderBuilderInterface
    {
        $customerBuilder = new PaymentCustomerBuilder();
        \call_user_func($callable, $customerBuilder);

        $this->paymentOrder->setCustomer($customerBuilder->getPaymentCustomer());

        return $this;
    }

    /**
     * Creates customer builder that allows to create Payment Customer definition.
     *
     * @return PaymentCustomerBuilderInterface
     */
    public function createCustomerBuilder(): PaymentCustomerBuilderInterface
    {
        return new PaymentCustomerBuilder();
    }

    /**
     * Sets Payment Customer definition.
     *
     * This value is required but can be set using `buildCustomer` method too.
     *
     * @param PaymentCustomerInterface $paymentCustomer
     *
     * @return PaymentOrderBuilderInterface
     */
    public function setCustomer(PaymentCustomerInterface $paymentCustomer): PaymentOrderBuilderInterface
    {
        $this->paymentOrder->setCustomer($paymentCustomer);

        return $this;
    }

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
    public function buildAddress(callable $callable): PaymentOrderBuilderInterface
    {
        $addressBuilder = new PaymentAddressBuilder();
        \call_user_func($callable, $addressBuilder);

        $this->paymentOrder->setAddress($addressBuilder->getPaymentAddress());

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
     * @param PaymentAddressInterface $address
     *
     * @return PaymentOrderBuilderInterface
     */
    public function setAddress(PaymentAddressInterface $address): PaymentOrderBuilderInterface
    {
        $this->paymentOrder->setAddress($address);

        return $this;
    }

    /**
     * Adds Payment Product definition to order.
     *
     * @param PaymentProductInterface $paymentProduct
     *
     * @return PaymentOrderBuilderInterface
     */
    public function addProduct(PaymentProductInterface $paymentProduct): PaymentOrderBuilderInterface
    {
        $products = $this->paymentOrder->getProducts();
        $products[] = $paymentProduct;

        $this->paymentOrder->setProducts($products);

        return $this;
    }

    /**
     * Creates payment product builder that allows to create Payment Product definition.
     *
     * @return PaymentProductBuilderInterface
     */
    public function createProductBuilder(): PaymentProductBuilderInterface
    {
        return new PaymentProductBuilder();
    }

    /**
     * Returns Payment Order definition.
     *
     * @return PaymentOrderInterface
     */
    public function getPaymentOrder(): PaymentOrderInterface
    {
        return $this->paymentOrder;
    }

    /**
     * @return void
     */
    protected function initializePaymentOrder(): void
    {
        $this->paymentOrder = new PaymentOrder();
    }
}
