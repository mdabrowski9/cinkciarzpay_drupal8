<?php

declare(strict_types=1);

namespace CKPL\Pay\Refund\Verifier;

use CKPL\Pay\Exception\PayloadException;
use CKPL\Pay\Exception\RefundStatusException;
use CKPL\Pay\Refund\Status\Status;
use CKPL\Pay\Refund\Status\StatusInterface;
use CKPL\Pay\Security\JWT\Collection\DecodedCollectionInterface;

/**
 * Class Verifier.
 *
 * @package CKPL\Pay\Refund\Verifier
 */
class Verifier implements VerifierInterface
{
    /**
     * @var DecodedCollectionInterface
     */
    protected $decodedCollection;

    /**
     * Verifier constructor.
     *
     * @param DecodedCollectionInterface $decodedCollection
     */
    public function __construct(DecodedCollectionInterface $decodedCollection)
    {
        $this->decodedCollection = $decodedCollection;
    }

    /**
     * @throws RefundStatusException
     *
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface
    {
        $data = $this->getDataFromPayload();

        return new Status($data['refund_id'], $data['code'], $data['external_refund_id']);
    }

    /**
     * @throws RefundStatusException
     *
     * @return array
     */
    protected function getDataFromPayload(): array
    {
        $payload = $this->decodedCollection->getPayload();

        try {
            $externalPaymentId = $payload->hasElement('externalRefundId')
                ? $payload->expectStringOrNull('externalRefundId')
                : null;

            return [
                'refund_id' => $payload->expectStringOrNull('refundId'),
                'external_refund_id' => $externalPaymentId,
                'code' => $payload->expectStringOrNull('code'),
            ];
        } catch (PayloadException $e) {
            throw new RefundStatusException('Status response contains invalid data.', 0, $e);
        }
    }
}
