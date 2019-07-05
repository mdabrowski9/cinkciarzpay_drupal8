<?php

declare(strict_types=1);

namespace CKPL\Pay\Model\Request;

use CKPL\Pay\Endpoint\MakePaymentEndpoint;
use CKPL\Pay\Model\RequestModelInterface;

/**
 * Class PaymentOrderRequestModel.
 *
 * @package CKPL\Pay\Model\Request
 */
class PaymentOrderRequestModel implements RequestModelInterface
{
    /**
     * @var PaymentCustomerRequestModel|null
     */
    protected $customer;

    /**
     * @var PaymentAddressRequestModel|null
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
     * @var array|null
     */
    protected $products;

    /**
     * @return PaymentCustomerRequestModel|null
     */
    public function getCustomer(): ?PaymentCustomerRequestModel
    {
        return $this->customer;
    }

    /**
     * @param PaymentCustomerRequestModel|null $customer
     *
     * @return RequestModelInterface
     */
    public function setCustomer(PaymentCustomerRequestModel $customer): RequestModelInterface
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return PaymentAddressRequestModel|null
     */
    public function getAddress(): ?PaymentAddressRequestModel
    {
        return $this->address;
    }

    /**
     * @param PaymentAddressRequestModel $address
     *
     * @return RequestModelInterface
     */
    public function setAddress(PaymentAddressRequestModel $address): RequestModelInterface
    {
        $this->address = $address;

        return $address;
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
     * @return RequestModelInterface
     */
    public function setOrderUrl(string $orderUrl): RequestModelInterface
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
     * @return RequestModelInterface
     */
    public function setAdditionalInformation(string $additionalInformation): RequestModelInterface
    {
        $this->additionalInformation = $additionalInformation;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getProducts(): ?array
    {
        return $this->products;
    }

    /**
     * @param array $products
     *
     * @return RequestModelInterface
     */
    public function setProducts(array $products): RequestModelInterface
    {
        $this->products = $products;

        return $this;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return MakePaymentEndpoint::class;
    }

    /**
     * @return array
     */
    public function raw(): array
    {
        $result = [];

        if (null !== $this->getOrderUrl()) {
            $result['orderUrl'] = $this->getOrderUrl();
        }

        if (null !== $this->getAdditionalInformation()) {
            $result['additionalInformation'] = $this->getAdditionalInformation();
        }

        if (null !== $this->getProducts()) {
            $products = [];

            foreach ($this->getProducts() as $product) {
                if (!($product instanceof PaymentProductRequestModel)) {
                    continue;
                }

                $products[] = $product->raw();
            }

            $result['products'] = $products;
        }

        if (null !== $this->getAddress()) {
            $result['shippingAddress'] = $this->getAddress()->raw();
        }

        if (null !== $this->getCustomer()) {
            $result['customer'] = $this->getCustomer()->raw();
        }

        return $result;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return RequestModelInterface::JSON_OBJECT;
    }
}
