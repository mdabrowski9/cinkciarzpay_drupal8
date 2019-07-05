<?php

declare(strict_types=1);

namespace CKPL\Pay\Payment\Verifier;

use CKPL\Pay\Exception\PayloadException;
use CKPL\Pay\Exception\PaymentStatusException;
use CKPL\Pay\Payment\Status\Status;
use CKPL\Pay\Payment\Status\StatusInterface;
use CKPL\Pay\Security\JWT\Collection\DecodedCollectionInterface;

/**
 * Class Verifier.
 *
 * @package CKPL\Pay\Payment\Verifier
 */
class Verifier implements VerifierInterface
{
    /**
     * @var DecodedCollectionInterface
     */
    protected $decodedCollection;

    /**
     * @type string
     */
    protected const PAYMENT_ID = 'paymentId';

    /**
     * @type string
     */
    protected const EXTERNAL_PAYMENT_ID = 'externalPaymentId';

    /**
     * @type string
     */
    protected const CODE = 'code';

    /**
     * @type string
     */
    protected const DESCRIPTION = 'description';

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
     * @throws PaymentStatusException
     *
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface
    {
        $data = $this->getDataFromPayload();

        return new Status($data['payment_id'], $data['external_payment_id'], $data[static::CODE], $data[static::DESCRIPTION]);
    }

    /**
     * @throws PaymentStatusException
     *
     * @return array
     */
    protected function getDataFromPayload(): array
    {
        $payload = $this->decodedCollection->getPayload();

        try {
            $description = $payload->hasElement(static::DESCRIPTION)
                ? $payload->expectStringOrNull(static::DESCRIPTION)
                : null;

            return [
                'payment_id' => $payload->expectStringOrNull(static::PAYMENT_ID),
                'external_payment_id' => $payload->expectStringOrNull(static::EXTERNAL_PAYMENT_ID),
                static::CODE => $payload->expectStringOrNull(static::CODE),
                static::DESCRIPTION => $description,
            ];
        } catch (PayloadException $e) {
            throw new PaymentStatusException('Status response contains invalid data.', 0, $e);
        }
    }
}
