<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Address;

/**
 * Class PaymentAddress.
 *
 * @package CKPL\Pay\Definition\Payment\Address
 */
class PaymentAddress implements PaymentAddressInterface
{
    /**
     * @var string|null
     */
    protected $street;

    /**
     * @var string|null
     */
    protected $postalCode;

    /**
     * @var string|null
     */
    protected $state;

    /**
     * @var string|null
     */
    protected $city;

    /**
     * @var string|null
     */
    protected $country;

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     *
     * @return PaymentAddress
     */
    public function setStreet(string $street): PaymentAddress
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     *
     * @return PaymentAddress
     */
    public function setPostalCode(string $postalCode): PaymentAddress
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return PaymentAddress
     */
    public function setState(string $state): PaymentAddress
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return PaymentAddress
     */
    public function setCity(string $city): PaymentAddress
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return PaymentAddress
     */
    public function setCountry(string $country): PaymentAddress
    {
        $this->country = $country;

        return $this;
    }
}
