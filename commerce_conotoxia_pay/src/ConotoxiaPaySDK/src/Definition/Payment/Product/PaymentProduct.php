<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Product;

use CKPL\Pay\Definition\Amount\AmountInterface;

/**
 * Class PaymentProduct.
 *
 * @package CKPL\Pay\Definition\Payment\Product
 */
class PaymentProduct implements PaymentProductInterface
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
     * @var AmountInterface|null
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
     * @return PaymentProduct
     */
    public function setName(string $name): PaymentProduct
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
     * @return PaymentProduct
     */
    public function setDescription(string $description): PaymentProduct
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
     * @return PaymentProduct
     */
    public function setQuantity(int $quantity): PaymentProduct
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return AmountInterface|null
     */
    public function getAmount(): ?AmountInterface
    {
        return $this->amount;
    }

    /**
     * @param AmountInterface $amount
     *
     * @return PaymentProduct
     */
    public function setAmount(AmountInterface $amount): PaymentProduct
    {
        $this->amount = $amount;

        return $this;
    }
}
