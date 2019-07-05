<?php

namespace Drupal\commerce_conotoxia_pay\Exceptions;

use Drupal\commerce_conotoxia_pay\Translation\Translation;

/**
 * Class PaymentResponseException
 * @package Drupal\commerce_conotoxia_pay\Exceptions
 */
class PaymentResponseException extends \Exception
{
    /**
     * PaymentResponseException constructor.
     */
    public function __construct()
    {
        parent::__construct(Translation::PAYMENT_RESPONSE_EXCEPTION);
    }
}
