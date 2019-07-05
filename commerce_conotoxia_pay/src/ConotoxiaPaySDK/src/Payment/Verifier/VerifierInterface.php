<?php

declare(strict_types=1);

namespace CKPL\Pay\Payment\Verifier;

use CKPL\Pay\Payment\Status\StatusInterface;

/**
 * Interface VerifierInterface.
 *
 * @package CKPL\Pay\Payment\Verifier
 */
interface VerifierInterface
{
    /**
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface;
}
