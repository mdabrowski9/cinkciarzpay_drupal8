<?php

declare(strict_types=1);

namespace CKPL\Pay\Model\Request;

use CKPL\Pay\Endpoint\MakePaymentEndpoint;
use CKPL\Pay\Model\RequestModelInterface;

/**
 * Class PaymentCustomerRequestModel.
 *
 * @package CKPL\Pay\Model\Request
 */
class PaymentCustomerRequestModel implements RequestModelInterface
{
    /**
     * @var string|null
     */
    protected $firstName;

    /**
     * @var string|null
     */
    protected $lastName;

    /**
     * @var string|null
     */
    protected $companyName;

    /**
     * @var string|null
     */
    protected $email;

    /**
     * @var string|null
     */
    protected $phone;

    /**
     * @var PaymentAddressRequestModel|null
     */
    protected $address;

    /**
     * @var string|null
     */
    protected $additionalInformation;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return PaymentCustomerRequestModel
     */
    public function setFirstName(string $firstName): PaymentCustomerRequestModel
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return PaymentCustomerRequestModel
     */
    public function setLastName(string $lastName): PaymentCustomerRequestModel
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     *
     * @return PaymentCustomerRequestModel
     */
    public function setCompanyName(string $companyName): PaymentCustomerRequestModel
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return PaymentCustomerRequestModel
     */
    public function setEmail(string $email): PaymentCustomerRequestModel
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return PaymentCustomerRequestModel
     */
    public function setPhone(string $phone): PaymentCustomerRequestModel
    {
        $this->phone = $phone;

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
     * @return PaymentCustomerRequestModel
     */
    public function setAddress(PaymentAddressRequestModel $address): PaymentCustomerRequestModel
    {
        $this->address = $address;

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
     * @return PaymentCustomerRequestModel
     */
    public function setAdditionalInformation(string $additionalInformation): PaymentCustomerRequestModel
    {
        $this->additionalInformation = $additionalInformation;

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
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
        ];

        if (null !== $this->getCompanyName()) {
            $result['companyName'] = $this->getCompanyName();
        }

        if (null !== $this->getPhone()) {
            $result['phone'] = $this->getPhone();
        }

        if (null !== $this->getAddress()) {
            $result['address'] = $this->getAddress()->raw();
        }

        if (null !== $this->getAdditionalInformation()) {
            $result['additionalInformation'] = $this->getAdditionalInformation();
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
