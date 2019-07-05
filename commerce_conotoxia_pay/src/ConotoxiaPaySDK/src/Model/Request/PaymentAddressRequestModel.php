<?php

declare(strict_types=1);

namespace CKPL\Pay\Model\Request;

use CKPL\Pay\Endpoint\MakePaymentEndpoint;
use CKPL\Pay\Model\RequestModelInterface;

/**
 * Class PaymentAddressRequestModel.
 *
 * @package CKPL\Pay\Model\Request
 */
class PaymentAddressRequestModel implements RequestModelInterface
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
     * @param string $street
     *
     * @return RequestModelInterface
     */
    public function setStreet(string $street): RequestModelInterface
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
     * @return RequestModelInterface
     */
    public function setPostalCode(string $postalCode): RequestModelInterface
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
     * @return RequestModelInterface
     */
    public function setState(string $state): RequestModelInterface
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
     * @return RequestModelInterface
     */
    public function setCity(string $city): RequestModelInterface
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
     * @return RequestModelInterface
     */
    public function setCountry(string $country): RequestModelInterface
    {
        $this->country = $country;

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
        $result = [
            'street' => $this->getStreet(),
            'postalCode' => $this->getPostalCode(),
            'city' => $this->getCity(),
            'country' => $this->getCountry(),
        ];

        if (null !== $this->getState()) {
            $result['state'] = $this->getState();
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
