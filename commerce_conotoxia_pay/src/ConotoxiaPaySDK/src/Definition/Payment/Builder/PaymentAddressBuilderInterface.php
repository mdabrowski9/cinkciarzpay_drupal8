<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Builder;

use CKPL\Pay\Definition\Payment\Address\PaymentAddressInterface;
use CKPL\Pay\Exception\Definition\PaymentAddressException;

/**
 * Interface PaymentAddressBuilderInterface.
 *
 * @package CKPL\Pay\Definition\Payment\Builder
 */
interface PaymentAddressBuilderInterface
{
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
    public function setStreet(string $street): PaymentAddressBuilderInterface;

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
    public function setPostalCode(string $postalCode): PaymentAddressBuilderInterface;

    /**
     * State.
     *
     * Min 1 character, max 100 characters.
     *
     * @param string $state
     *
     * @return PaymentAddressBuilderInterface
     */
    public function setState(string $state): PaymentAddressBuilderInterface;

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
    public function setCity(string $city): PaymentAddressBuilderInterface;

    /**
     * Two-letter country code according to ISO 3166-1 alpha-2.
     *
     * This value is required!
     *
     * @param string $country
     *
     * @return PaymentAddressBuilderInterface
     */
    public function setCountry(string $country): PaymentAddressBuilderInterface;

    /**
     * Returns Payment Address definition.
     *
     * @throws PaymentAddressException if one of required parameters is missing
     *
     * @return PaymentAddressInterface
     */
    public function getPaymentAddress(): PaymentAddressInterface;
}
