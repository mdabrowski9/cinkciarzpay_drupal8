<?php

declare(strict_types=1);

namespace CKPL\Pay\Payment;

use CKPL\Pay\Definition\Payment\Builder\PaymentBuilder;
use CKPL\Pay\Definition\Payment\Builder\PaymentBuilderInterface;
use CKPL\Pay\Definition\Payment\PaymentInterface;
use CKPL\Pay\Endpoint\GetPaymentsEndpoint;
use CKPL\Pay\Endpoint\MakePaymentEndpoint;
use CKPL\Pay\Exception\ClientException;
use CKPL\Pay\Exception\DecodedReturnException;
use CKPL\Pay\Exception\Exception;
use CKPL\Pay\Model\Collection\PaymentResponseModelCollection;
use CKPL\Pay\Model\Response\CreatedPaymentResponseModel;
use CKPL\Pay\Payment\DecodedReturn\DecodedReturnInterface;
use CKPL\Pay\Payment\ReturnDecoder\ReturnDecoder;
use CKPL\Pay\Payment\Status\StatusInterface;
use CKPL\Pay\Service\BaseService;

/**
 * Class PaymentManager.
 *
 * Payments related features such as
 * ability to create payment, check payment status,
 * decode return response, get list of all payments related to client in service.
 *
 * @package CKPL\Pay\Payment
 */
class PaymentManager extends BaseService implements PaymentManagerInterface
{
    /**
     * Creates payments builder that can help with generating Payment definition.
     *
     * @return PaymentBuilderInterface
     */
    public function createPaymentBuilder(): PaymentBuilderInterface
    {
        return new PaymentBuilder();
    }

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
    public function getPayments(array $parameters = []): PaymentResponseModelCollection
    {
        $client = $this->dependencyFactory->createClient(
            new GetPaymentsEndpoint(),
            $this->configuration,
            $this->dependencyFactory->getSecurityManager(),
            $this->dependencyFactory->getAuthenticationManager()
        );

        $client->request()->parameters($parameters)->send();

        $paymentCollection = $client->getResponse()->getProcessedOutput();

        if ($paymentCollection instanceof PaymentResponseModelCollection) {
            return $paymentCollection;
        } else {
            throw new Exception(static::UNSUPPORTED_RESPONSE_MODEL_EXCEPTION);
        }
    }

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
    public function makePayment(PaymentInterface $payment): CreatedPaymentResponseModel
    {
        $client = $this->dependencyFactory->createClient(
            new MakePaymentEndpoint($this->configuration),
            $this->configuration,
            $this->dependencyFactory->getSecurityManager(),
            $this->dependencyFactory->getAuthenticationManager()
        );

        $client->request()->parameters($this->paymentToParameters($payment))->send();

        $paymentModel = $client->getResponse()->getProcessedOutput();

        if ($paymentModel instanceof CreatedPaymentResponseModel) {
            return $paymentModel;
        } else {
            throw new Exception(static::UNSUPPORTED_RESPONSE_MODEL_EXCEPTION);
        }
    }

    /**
     * Decodes received payment notification response and returns payment status.
     *
     * Example:
     *     $this->getPaymentStatus(\file_get_contents("php://input"));
     *
     * @param string $input
     *
     * @return StatusInterface
     */
    public function getPaymentStatus(string $input): StatusInterface
    {
        $verifier = $this->dependencyFactory->createPaymentVerifier(
            $this->dependencyFactory->getSecurityManager()->decodeResponse($input)
        );

        return $verifier->getStatus();
    }

    /**
     * Decodes return / error URL data.
     *
     * Example:
     *     $this->decodeReturn($_GET['data']);
     *
     * @param string $return
     *
     * @throws DecodedReturnException decode-level related problem e.g. missing parameter in response.
     *
     * @return DecodedReturnInterface
     */
    public function decodeReturn(string $return): DecodedReturnInterface
    {
        $returnDecoder = new ReturnDecoder($this->dependencyFactory->getSecurityManager());

        return $returnDecoder->decode($return);
    }

    /**
     * @param PaymentInterface $payment
     *
     * @return array
     */
    protected function paymentToParameters(PaymentInterface $payment): array
    {
        return [
            'currency' => ($payment->getAmount() ? $payment->getAmount()->getCurrency() : null),
            'value' => ($payment->getAmount() ? $payment->getAmount()->getValue() : null),
            'internal_payment_id' => $payment->getExternalPaymentId(),
            'point_of_sale' => $this->configuration->getPointOfSale(),
            'category' => $this->configuration->getCategory(),
            'description' => $payment->getDescription(),
            'order' => $payment->getOrder(),
            'allow_pay_later' => $payment->getAllowPayLater(),
            'notification_url' => $payment->getNotificationUrl(),
            'return_url' => $payment->getReturnUrl(),
            'error_url' => $payment->getErrorUrl(),
        ];
    }
}
