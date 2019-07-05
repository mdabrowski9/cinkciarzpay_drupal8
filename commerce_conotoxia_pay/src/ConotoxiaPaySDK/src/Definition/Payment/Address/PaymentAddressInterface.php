<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Address;

/**
 * Interface PaymentAddressInterface.
 *
 * @package CKPL\Pay\Definition\Payment\Address
 */
interface PaymentAddressInterface
{
    /**
     * @return string|null
     */
    public function getStreet(): ?string;

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string;

    /**
     * @return string|null
     */
    public function getState(): ?string;

    /**
     * @return string|null
     */
    public function getCity(): ?string;

    /**
     * @return string|null
     */
    public function getCountry(): ?string;
}
