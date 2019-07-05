<?php

declare(strict_types=1);

namespace CKPL\Pay\Payment;

use CKPL\Pay\Definition\Payment\Builder\PaymentBuilderInterface;
use CKPL\Pay\Definition\Payment\PaymentInterface;
use CKPL\Pay\Exception\ClientException;
use CKPL\Pay\Exception\DecodedReturnException;
use CKPL\Pay\Exception\Exception;
use CKPL\Pay\Model\Collection\PaymentResponseModelCollection;
use CKPL\Pay\Model\Response\CreatedPaymentResponseModel;
use CKPL\Pay\Payment\DecodedReturn\DecodedReturnInterface;
use CKPL\Pay\Payment\Status\StatusInterface;

/**
 * Interface PaymentManagerInterface.
 *
 * Payments related features such as
 * ability to create payment, check payment status,
 * decode return response, get list of all payments related to client in service.
 *
 * @package CKPL\Pay\Payment
 */
interface PaymentManagerInterface
{
    /**
     * Gets all payments related to client from Payment Service.
     *
     * Entries can be filtered using following parameters:
     * * `payments_ids` - IDs of payments that will be fetched from Payment Service.
     * * `external_payment_id` - External (app) payment ID. Method will return only payments with specified external ID.
     * * `creation_date_from` - creation time in Zulu format. Method will return only payments created after
     *                          specified date.
     * * `creation_date_to` - creation time in Zulu format. Method will return only payments created before
     *                          specified date.
     * * `booked_date_from` - time, in Zulu format, when payment was booked. Method will return only payments booked
     *                        after specified date.
     * * `booked_date_to` - time, in Zulu format, when payment was booked. Method will return only payments booked
     *                      before specified date.
     * * `page_number` - page number.
     * * `page_size` - number of payments per page.
     *
     * @param array $parameters filter parameters
     *
     * @throws ClientException request-level related problem e.g. HTTP errors, API errors.
     * @throws Exception       library-level related problem e.g. invalid data model.
     *
     * @return PaymentResponseModelCollection
     */
    public function getPayments(array $parameters = []): PaymentResponseModelCollection;

    /**
     * Creates payments builder that can help with generating Payment definition.
     *
     * @return PaymentBuilderInterface
     */
    public function createPaymentBuilder(): PaymentBuilderInterface;

    /**
     * Creates payment in Payment Service from definition and returns
     * payment ID and URL given by service.
     *
     * Received URL must be forwarded to user to be able to proceed with payment.
     *
     * @param PaymentInterface $payment payment definition
     *
     * @throws ClientException request-level related problem e.g. HTTP errors, API errors.
     * @throws Exception       library-level related problem e.g. invalid data model.
     *
     * @return CreatedPaymentResponseModel
     */
    public function makePayment(PaymentInterface $payment): CreatedPaymentResponseModel;

    /**
     * Decodes received payment notification response and returns payment status.
     *
     * Example:
     *     $this->payments()->getPaymentStatus(\file_get_contents("php://input"));
     *
     * @param string $input
     *
     * @return StatusInterface
     */
    public function getPaymentStatus(string $input): StatusInterface;

    /**
     * Decodes return / error URL data.
     *
     * Example:
     *     $this->payments()->decodeReturn($_GET['data']);
     *
     * @param string $return
     *
     * @throws DecodedReturnException decode-level related problem e.g. missing parameter in response.
     *
     * @return DecodedReturnInterface
     */
    public function decodeReturn(string $return): DecodedReturnInterface;
}
