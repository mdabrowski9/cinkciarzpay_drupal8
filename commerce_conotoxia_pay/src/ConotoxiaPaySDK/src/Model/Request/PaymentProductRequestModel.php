<?php

declare(strict_types=1);

namespace CKPL\Pay\Model\Request;

use CKPL\Pay\Endpoint\MakePaymentEndpoint;
use CKPL\Pay\Model\RequestModelInterface;

/**
 * Class PaymentProductRequestModel.
 *
 * @package CKPL\Pay\Model\Request
 */
class PaymentProductRequestModel implements RequestModelInterface
{
    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @var int|null
     */
    protected $quantity;

    /**
     * @var TotalAmountRequestModel|null
     */
    protected $amount;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return PaymentProductRequestModel
     */
    public function setName(string $name): PaymentProductRequestModel
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return PaymentProductRequestModel
     */
    public function setDescription(string $description): PaymentProductRequestModel
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return PaymentProductRequestModel
     */
    public function setQuantity(int $quantity): PaymentProductRequestModel
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return TotalAmountRequestModel|null
     */
    public function getAmount(): ?TotalAmountRequestModel
    {
        return $this->amount;
    }

    /**
     * @param TotalAmountRequestModel|null $amount
     *
     * @return PaymentProductRequestModel
     */
    public function setAmount(TotalAmountRequestModel $amount): PaymentProductRequestModel
    {
        $this->amount = $amount;

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
            'name' => $this->getName(),
            'quantity' => $this->getQuantity(),
            'amount' => ($this->getAmount() ? $this->getAmount()->raw() : null),
        ];

        if (null !== $this->getDescription()) {
            $result['description'] = $this->getDescription();
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
