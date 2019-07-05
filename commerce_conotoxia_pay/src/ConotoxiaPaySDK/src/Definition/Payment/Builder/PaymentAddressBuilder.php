<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Builder;

use CKPL\Pay\Definition\Payment\Address\PaymentAddress;
use CKPL\Pay\Definition\Payment\Address\PaymentAddressInterface;
use CKPL\Pay\Exception\Definition\PaymentAddressException;

/**
 * Class PaymentAddressBuilder.
 *
 * @package CKPL\Pay\Definition\Payment\Builder
 */
class PaymentAddressBuilder implements PaymentAddressBuilderInterface
{
    /**
     * @var PaymentAddress
     */
    protected $paymentAddress;

    /**
     * PaymentAddressBuilder constructor.
     */
    public function __construct()
    {
        $this->initializePaymentAddress();
    }

    /**
     * Street name and number.
     *
     * Min 1 character, max 138 characters.
     *
     * This value is required!
     *
     * @param string $street
     *
     * @return PaymentAddressBuilderInterface
     */
    public function setStreet(string $street): PaymentAddressBuilderInterface
    {
        $this->paymentAddress->setStreet($street);

        return $this;
    }

    /**
     * Postcode.
     *
     * Min 1 character, max 16 characters.
     *
     * This value is required!
     *
     * @param string $postalCode
     *
     * @return PaymentAddressBuilderInterface
     */
    public function setPostalCode(string $postalCode): PaymentAddressBuilderInterface
    {
        $this->paymentAddress->setPostalCode($postalCode);

        return $this;
    }

    /**
     * State.
     *
     * Min 1 character, max 100 characters.
     *
     * @param string $state
     *
     * @return PaymentAddressBuilderInterface
     */
    public function setState(string $state): PaymentAddressBuilderInterface
    {
        $this->paymentAddress->setState($state);

        return $this;
    }

    /**
     * City.
     *
     * Min 1 character, max 100 characters.
     *
     * This value is required!
     *
     * @param string $city
     *
     * @return PaymentAddressBuilderInterface
     */
    public function setCity(string $city): PaymentAddressBuilderInterface
    {
        $this->paymentAddress->setCity($city);

        return $this;
    }

    /**
     * Two-letter country code according to ISO 3166-1 alpha-2.
     *
     * This value is required!
     *
     * @param string $country
     *
     * @return PaymentAddressBuilderInterface
     */
    public function setCountry(string $country): PaymentAddressBuilderInterface
    {
        $this->paymentAddress->setCountry($country);

        return $this;
    }

    /**
     * Returns Payment Address definition.
     *
     * @throws PaymentAddressException if one of required parameters is missing
     *
     * @return PaymentAddressInterface
     */
    public function getPaymentAddress(): PaymentAddressInterface
    {
        if (empty($this->paymentAddress->getStreet())) {
            throw new PaymentAddressException('Missing street in payment address.');
        }

        if (empty($this->paymentAddress->getPostalCode())) {
            throw new PaymentAddressException('Missing postal code in payment address.');
        }

        if (empty($this->paymentAddress->getCity())) {
            throw new PaymentAddressException('Missing city in payment address.');
        }

        if (empty($this->paymentAddress->getCountry())) {
            throw new PaymentAddressException('Missing country in payment address.');
        }

        return $this->paymentAddress;
    }

    /**
     * @return void
     */
    protected function initializePaymentAddress(): void
    {
        $this->paymentAddress = new PaymentAddress();
    }
}
