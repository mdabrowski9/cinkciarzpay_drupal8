<?php

namespace Drupal\commerce_conotoxia_pay\Exceptions;

use Drupal\commerce_conotoxia_pay\Translation\Translation;

/**
 * Class HostParameterException
 * @package Drupal\commerce_conotoxia_pay\Exceptions
 */
class HostParameterException extends \Exception
{
    /**
     * HostParameterException constructor.
     */
    public function __construct()
    {
        parent::__construct(Translation::HOST_PARAMETER_EXCEPTION);
    }
}
