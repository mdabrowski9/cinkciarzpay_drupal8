<?php

declare(strict_types=1);

namespace CKPL\Pay\Endpoint;

use CKPL\Pay\Client\RawOutput\RawOutputInterface;
use CKPL\Pay\Configuration\ConfigurationInterface;
use CKPL\Pay\Definition\Amount\AmountInterface;
use CKPL\Pay\Definition\Payment\Address\PaymentAddressInterface;
use CKPL\Pay\Definition\Payment\Customer\PaymentCustomerInterface;
use CKPL\Pay\Definition\Payment\Order\PaymentOrderInterface;
use CKPL\Pay\Definition\Payment\Product\PaymentProductInterface;
use CKPL\Pay\Endpoint\ConfigurationFactory\EndpointConfigurationFactoryInterface;
use CKPL\Pay\Exception\Endpoint\MakePaymentEndpointException;
use CKPL\Pay\Exception\PayloadException;
use CKPL\Pay\Model\ProcessedInputInterface;
use CKPL\Pay\Model\ProcessedOutputInterface;
use CKPL\Pay\Model\Request\PaymentAddressRequestModel;
use CKPL\Pay\Model\Request\PaymentCustomerRequestModel;
use CKPL\Pay\Model\Request\PaymentOrderRequestModel;
use CKPL\Pay\Model\Request\PaymentProductRequestModel;
use CKPL\Pay\Model\Request\PaymentRequestModel;
use CKPL\Pay\Model\Request\TotalAmountRequestModel;
use CKPL\Pay\Model\Response\CreatedPaymentResponseModel;

/**
 * Class MakePaymentEndpoint.
 *
 * @package CKPL\Pay\Endpoint
 */
class MakePaymentEndpoint implements EndpointInterface
{
    /**
     * @type string
     */
    const PARAMETER_INTERNAL_PAYMENT_ID = 'internal_payment_id';

    /**
     * @type string
     */
    const PARAMETER_POINT_OF_SALE = 'point_of_sale';

    /**
     * @type string
     */
    const PARAMETER_CURRENCY = 'currency';

    /**
     * @type string
     */
    const PARAMETER_VALUE = 'value';

    /**
     * @type string
     */
    const PARAMETER_CATEGORY = 'category';

    /**
     * @type string
     */
    const PARAMETER_DESCRIPTION = 'description';

    /**
     * @type string
     */
    const PARAMETER_NOTIFICATION_URL = 'notification_url';

    /**
     * @type string
     */
    const PARAMETER_RETURN_URL = 'return_url';

    /**
     * @type string
     */
    const PARAMETER_ERROR_URL = 'error_url';

    /**
     * @type string
     */
    const PARAMETER_DISABLE_PAY_LATER = 'allow_pay_later';

    /**
     * @type string
     */
    const RESPONSE_PAYMENT_ID = 'paymentId';

    /**
     * @type string
     */
    const RESPONSE_APPROVE_URL = 'approveUrl';

    /**
     * @type string
     */
    const RESPONSE_ORDER = 'order';

    /**
     * @type string
     */
    protected const ENDPOINT = 'payments';

    /**
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * MakePaymentEndpoint constructor.
     *
     * @param ConfigurationInterface $configuration
     */
    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @param EndpointConfigurationFactoryInterface $configurationFactory
     *
     * @return void
     */
    public function configuration(EndpointConfigurationFactoryInterface $configurationFactory): void
    {
        $configurationFactory
            ->url(static::ENDPOINT)
            ->asPost()
            ->toPayments()
            ->encodeWithJson()
            ->expectSignedResponse()
            ->signRequest()
            ->authorized();
    }

    /**
     * @param array $parameters
     *
     * @throws MakePaymentEndpointException
     *
     * @return ProcessedInputInterface|null
     */
    public function processRawInput(array $parameters): ?ProcessedInputInterface
    {
        $this->validateInput($parameters);

        $totalAmount = new TotalAmountRequestModel();
        $totalAmount->setCurrency($parameters[static::PARAMETER_CURRENCY]);
        $totalAmount->setValue($parameters[static::PARAMETER_VALUE]);

        $model = new PaymentRequestModel();
        $model->setExternalPaymentId($parameters[static::PARAMETER_INTERNAL_PAYMENT_ID]);
        $model->setPointOfSaleId($parameters[static::PARAMETER_POINT_OF_SALE]);
        $model->setCategory($parameters[static::PARAMETER_CATEGORY]);
        $model->setTotalAmount($totalAmount);
        $model->setDescription($parameters[static::PARAMETER_DESCRIPTION]);

        if (($parameters[static::RESPONSE_ORDER] ?? null) instanceof PaymentOrderInterface) {
            $model->setOrder($this->makeOrderRequestModel($parameters[static::RESPONSE_ORDER]));
        }

        if (isset($parameters[static::PARAMETER_DISABLE_PAY_LATER])) {
            $model->setDisablePayLater(!$parameters[static::PARAMETER_DISABLE_PAY_LATER]);
        }

        if (isset($parameters[static::PARAMETER_RETURN_URL])) {
            $model->setReturnUrl($parameters[static::PARAMETER_RETURN_URL]);
        } else {
            if (null !== $this->configuration->getReturnUrl()) {
                $model->setReturnUrl($this->configuration->getReturnUrl());
            }
        }

        if (isset($parameters[static::PARAMETER_ERROR_URL])) {
            $model->setErrorUrl($parameters[static::PARAMETER_ERROR_URL]);
        } else {
            if (null !== $this->configuration->getErrorUrl()) {
                $model->setErrorUrl($this->configuration->getErrorUrl());
            }
        }

        if (isset($parameters[static::PARAMETER_NOTIFICATION_URL])) {
            $model->setNotificationUrl($parameters[static::PARAMETER_NOTIFICATION_URL]);
        } else {
            if (null !== $this->configuration->getPaymentsNotificationUrl()) {
                $model->setNotificationUrl($this->configuration->getPaymentsNotificationUrl());
            }
        }

        return $model;
    }

    /**
     * @param RawOutputInterface $rawOutput
     *
     * @throws PayloadException
     * @throws MakePaymentEndpointException
     *
     * @return ProcessedOutputInterface
     */
    public function processRawOutput(RawOutputInterface $rawOutput): ProcessedOutputInterface
    {
        $payment = $rawOutput->getPayload();

        if (!$payment->hasElement(static::RESPONSE_PAYMENT_ID)) {
            throw new MakePaymentEndpointException(
                \sprintf(MakePaymentEndpointException::MISSING_RESPONSE_PARAMETER, static::RESPONSE_PAYMENT_ID)
            );
        }

        if (!$payment->hasElement(static::RESPONSE_APPROVE_URL)) {
            throw new MakePaymentEndpointException(
                \sprintf(MakePaymentEndpointException::MISSING_RESPONSE_PARAMETER, static::RESPONSE_APPROVE_URL)
            );
        }

        $model = new CreatedPaymentResponseModel();
        $model->setPaymentId($payment->expectStringOrNull(static::RESPONSE_PAYMENT_ID));
        $model->setApproveUrl($payment->expectStringOrNull(static::RESPONSE_APPROVE_URL));

        return $model;
    }

    /**
     * @param array $parameters
     *
     * @throws MakePaymentEndpointException
     *
     * @return void
     */
    protected function validateInput(array $parameters): void
    {
        $requiredParameters = [
            static::PARAMETER_CURRENCY, static::PARAMETER_VALUE,
            static::PARAMETER_INTERNAL_PAYMENT_ID, static::PARAMETER_POINT_OF_SALE,
            static::PARAMETER_CATEGORY, static::PARAMETER_DESCRIPTION,
        ];

        foreach ($requiredParameters as $requiredParameter) {
            if (!isset($parameters[$requiredParameter])) {
                throw new MakePaymentEndpointException(
                    \sprintf(MakePaymentEndpointException::MISSING_REQUEST_PARAMETERS, $requiredParameter)
                );
            }
        }
    }

    /**
     * @param PaymentOrderInterface $paymentOrder
     *
     * @return PaymentOrderRequestModel
     */
    protected function makeOrderRequestModel(PaymentOrderInterface $paymentOrder): PaymentOrderRequestModel
    {
        $model = new PaymentOrderRequestModel();

        if (null !== $paymentOrder->getOrderUrl()) {
            $model->setOrderUrl($paymentOrder->getOrderUrl());
        }

        if (null !== $paymentOrder->getAdditionalInformation()) {
            $model->setAdditionalInformation($paymentOrder->getAdditionalInformation());
        }

        if (null !== $paymentOrder->getCustomer()) {
            $model->setCustomer($this->makeCustomerRequestModel($paymentOrder->getCustomer()));
        }

        if (null !== $paymentOrder->getAddress()) {
            $model->setAddress($this->makeAddressRequestModel($paymentOrder->getAddress()));
        }

        if (null !== $paymentOrder->getProducts()) {
            $products = [];

            foreach ($paymentOrder->getProducts() as $product) {
                $products[] = $this->makeProductRequestModel($product);
            }

            $model->setProducts($products);
        }

        return $model;
    }

    /**
     * @param PaymentCustomerInterface $paymentCustomer
     *
     * @return PaymentCustomerRequestModel
     */
    protected function makeCustomerRequestModel(PaymentCustomerInterface $paymentCustomer): PaymentCustomerRequestModel
    {
        $model = new PaymentCustomerRequestModel();

        if (null !== $paymentCustomer->getFirstName()) {
            $model->setFirstName($paymentCustomer->getFirstName());
        }

        if (null !== $paymentCustomer->getLastName()) {
            $model->setLastName($paymentCustomer->getLastName());
        }

        if (null !== $paymentCustomer->getCompanyName()) {
            $model->setCompanyName($paymentCustomer->getCompanyName());
        }

        if (null !== $paymentCustomer->getPhone()) {
            $model->setPhone($paymentCustomer->getPhone());
        }

        if (null !== $paymentCustomer->getEmail()) {
            $model->setEmail($paymentCustomer->getEmail());
        }

        if (null !== $paymentCustomer->getAdditionalInformation()) {
            $model->setAdditionalInformation($paymentCustomer->getAdditionalInformation());
        }

        if (null !== $paymentCustomer->getAddress()) {
            $model->setAddress($this->makeAddressRequestModel($paymentCustomer->getAddress()));
        }

        return $model;
    }

    /**
     * @param PaymentAddressInterface $paymentAddress
     *
     * @return PaymentAddressRequestModel
     */
    protected function makeAddressRequestModel(PaymentAddressInterface $paymentAddress): PaymentAddressRequestModel
    {
        $model = new PaymentAddressRequestModel();

        if (null !== $paymentAddress->getCity()) {
            $model->setCity($paymentAddress->getCity());
        }

        if (null !== $paymentAddress->getCountry()) {
            $model->setCountry($paymentAddress->getCountry());
        }

        if (null !== $paymentAddress->getPostalCode()) {
            $model->setPostalCode($paymentAddress->getPostalCode());
        }

        if (null !== $paymentAddress->getState()) {
            $model->setState($paymentAddress->getState());
        }

        if (null !== $paymentAddress->getStreet()) {
            $model->setStreet($paymentAddress->getStreet());
        }

        return $model;
    }

    /**
     * @param PaymentProductInterface $paymentProduct
     *
     * @return PaymentProductRequestModel
     */
    protected function makeProductRequestModel(PaymentProductInterface $paymentProduct): PaymentProductRequestModel
    {
        $model = new PaymentProductRequestModel();

        if (null !== $paymentProduct->getName()) {
            $model->setName($paymentProduct->getName());
        }

        if (null !== $paymentProduct->getDescription()) {
            $model->setDescription($paymentProduct->getDescription());
        }

        if (null !== $paymentProduct->getAmount()) {
            $model->setAmount($this->makeAmountRequestModel($paymentProduct->getAmount()));
        }

        if (null !== $paymentProduct->getQuantity()) {
            $model->setQuantity($paymentProduct->getQuantity());
        }

        return $model;
    }

    /**
     * @param AmountInterface $amount
     *
     * @return TotalAmountRequestModel
     */
    protected function makeAmountRequestModel(AmountInterface $amount): TotalAmountRequestModel
    {
        $model = new TotalAmountRequestModel();

        if (null !== $amount->getCurrency()) {
            $model->setCurrency($amount->getCurrency());
        }

        if (null !== $amount->getValue()) {
            $model->setValue($amount->getValue());
        }

        return $model;
    }
}
