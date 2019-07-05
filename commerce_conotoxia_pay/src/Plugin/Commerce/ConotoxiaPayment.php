<?php

declare(strict_types=1);

namespace Drupal\commerce_conotoxia_pay\Plugin\Commerce;

require_once dirname(__DIR__).'../../ConotoxiaPaySDK/internals/autoload.php';

use CKPL\Pay\Configuration\ConfigurationInterface;
use CKPL\Pay\Configuration\Factory\ConfigurationFactory;
use CKPL\Pay\Definition\Payment\PaymentInterface;
use CKPL\Pay\Exception\MerchantManagerException;
use CKPL\Pay\Model\Response\CreatedPaymentResponseModel;
use CKPL\Pay\Pay;
use Drupal\address\Plugin\Field\FieldType\AddressItem;
use Drupal\commerce_order\Entity\Order;

/**
 * PaymentObject class.
 */
class ConotoxiaPayment
{
    /**
     * Type of algorithm.
     */
    const CONOTOXIA_ALGORITHM = 'SHA512';

    /**
     * Array with Conotoxia Payment Config data.
     *
     * @var array
     */
    private $conotoxia_pay_config;

    /**
     * @var Pay $pay
     */
    private $pay;

  /**
   * Prepare ConotoxiaPayment object for using.
   *
   * @param array $conotoxia_pay_config array with Conotoxia Payment Config data
   * @throws \CKPL\Pay\Exception\ConfigurationException
   */
    public function __construct(array $conotoxia_pay_config)
    {
        $this->conotoxia_pay_config = $conotoxia_pay_config;
        $this->pay = new Pay($this->buildPaymentConfig());
    }

  /**
   * @return ConfigurationInterface
   * @throws \CKPL\Pay\Exception\ConfigurationException
   */
    protected function buildPaymentConfig(): ConfigurationInterface
    {
            return ConfigurationFactory::fromArray([
                ConfigurationInterface::HOST => $this->conotoxia_pay_config['host'],
                ConfigurationInterface::OIDC => $this->conotoxia_pay_config['oidc'],
                ConfigurationInterface::CLIENT_ID => $this->conotoxia_pay_config['merchant_id'],
                ConfigurationInterface::CLIENT_SECRET => $this->conotoxia_pay_config['merchant_secret'],
                ConfigurationInterface::POINT_OF_SALE => $this->conotoxia_pay_config['pos_id'],
                ConfigurationInterface::PRIVATE_KEY => $this->conotoxia_pay_config['private_rsa_key'],
                ConfigurationInterface::PUBLIC_KEY => $this->conotoxia_pay_config['public_rsa_key'],
                ConfigurationInterface::STORAGE => new ConotoxiaPaymentStorage(),
                ConfigurationInterface::SIGN_ALGORITHM => static::CONOTOXIA_ALGORITHM,
            ]);
    }

    /**
     * @param string $input
     *
     * @return \CKPL\Pay\Payment\Status\StatusInterface
     */
    public function getConfirmStatus(string $input): \CKPL\Pay\Payment\Status\StatusInterface
    {
        return $this->pay->payments()->getPaymentStatus($input);
    }

    /**
     * @param \CKPL\Pay\Payment\Status\StatusInterface $status
     *
     * @return int
     */
    public function getConfirmOrderId(\CKPL\Pay\Payment\Status\StatusInterface $status): int
    {
        return (int) $status->getExternalPaymentId();
    }

    /**
     * @param Order       $order
     * @param AddressItem $address
     * @param string      $return_url
     * @param string      $error_url
     * @param string      $notification_url
     *
     * @return CreatedPaymentResponseModel
     *@throws \CKPL\Pay\Exception\ClientException
     * @throws \CKPL\Pay\Exception\Definition\AmountException
     * @throws \CKPL\Pay\Exception\Definition\PaymentCustomerException
     * @throws \CKPL\Pay\Exception\Definition\PaymentException
     * @throws \CKPL\Pay\Exception\Exception
     *
     */
    public function paymentProcess(
        Order $order,
        AddressItem $address,
        string $return_url,
        string $error_url,
        string $notification_url
    ): CreatedPaymentResponseModel {
        return $this->pay->payments()->makePayment($this->createPayment(
            $this->pay,
            $order,
            $address,
            $return_url,
            $error_url,
            $notification_url
        ));
    }

    /**
     * Save public key from service to local json file.
     */
    public function savePublicKeyToStorage()
    {
        $this->pay->pickSignatureKey();
    }

    /**
     * Send public key from shop to service.
     */
    public function setPublicKey()
    {
        try {
            $this->pay->merchant()->pickPublicKeyId();
        } catch (MerchantManagerException $exception) {
            $this->pay->merchant()->sendPublicKey();
        }
    }

    /**
     * @param Pay         $pay
     * @param Order       $order
     * @param AddressItem $address
     * @param string      $return_url
     * @param string      $error_url
     * @param string      $notification_url
     *
     * @return \CKPL\Pay\Definition\Payment\PaymentInterface
     *@throws \CKPL\Pay\Exception\Definition\AmountException
     * @throws \CKPL\Pay\Exception\Definition\PaymentCustomerException
     * @throws \CKPL\Pay\Exception\Definition\PaymentException
     *
     */
    public function createPayment(
        Pay $pay,
        Order $order,
        AddressItem $address,
        string $return_url,
        string $error_url,
        string $notification_url
    ): PaymentInterface {
        $payment_builder = $pay->payments()->createPaymentBuilder();
        $order_builder = $payment_builder->createOrderBuilder();
        $customer_builder = $order_builder->createCustomerBuilder();

        $amount = $payment_builder->createAmountBuilder()
            ->setValue($order->getTotalPrice()->getNumber())
            ->setCurrency($order->getTotalPrice()->getCurrencyCode())
            ->getAmount();

        $payment_order = $order_builder
            ->setCustomer(
                $customer_builder
                    ->setFirstName($address->getGivenName())
                    ->setLastName($address->getFamilyName())
                    ->setEmail($order->getEmail())
                    ->getPaymentCustomer()
            )
            ->getPaymentOrder();

        return $payment_builder
            ->setExternalPaymentId($order->id())
            ->setReturnUrl($return_url)
            ->setErrorUrl($error_url)
            ->setNotificationUrl($notification_url)
            ->setAmount($amount)
            ->setDescription('Store_URL'.' #'.$order->getOrderNumber())
            ->setOrder($payment_order)
            ->getPayment();
    }
}
