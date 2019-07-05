<?php

declare(strict_types=1);

namespace CKPL\Pay\Refund\Verifier;

use CKPL\Pay\Refund\Status\StatusInterface;

/**
 * Interface VerifierInterface.
 *
 * @package CKPL\Pay\Refund\Verifier
 */
interface VerifierInterface
{
    /**
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface;
}
