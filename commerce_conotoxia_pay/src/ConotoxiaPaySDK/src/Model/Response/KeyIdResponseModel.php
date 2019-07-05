<?php

declare(strict_types=1);

namespace CKPL\Pay\Model\Response;

use CKPL\Pay\Endpoint\SendPublicKeyEndpoint;
use CKPL\Pay\Model\ResponseModelInterface;

/**
 * Class KeyIdResponseModel.
 *
 * @package CKPL\Pay\Model\Response
 */
class KeyIdResponseModel implements ResponseModelInterface
{
    /**
     * @var string|null
     */
    protected $keyId;

    /**
     * @return string|null
     */
    public function getKeyId(): ?string
    {
        return $this->keyId;
    }

    /**
     * @param string|null $keyId
     *
     * @return ResponseModelInterface
     */
    public function setKeyId(string $keyId): ResponseModelInterface
    {
        $this->keyId = $keyId;

        return $this;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return SendPublicKeyEndpoint::class;
    }
}
