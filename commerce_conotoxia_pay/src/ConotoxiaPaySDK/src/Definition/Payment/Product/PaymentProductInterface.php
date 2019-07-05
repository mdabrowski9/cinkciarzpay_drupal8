<?php

declare(strict_types=1);

namespace CKPL\Pay\Definition\Payment\Product;

use CKPL\Pay\Definition\Amount\AmountInterface;

/**
 * Interface PaymentProductInterface.
 *
 * @package CKPL\Pay\Definition\Payment\Product
 */
interface PaymentProductInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @return int|null
     */
    public function getQuantity(): ?int;

    /**
     * @return AmountInterface|null
     */
    public function getAmount(): ?AmountInterface;
}
