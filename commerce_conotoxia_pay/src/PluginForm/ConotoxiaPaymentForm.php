<?php

namespace Drupal\commerce_conotoxia_pay\PluginForm;

use CKPL\Pay\Exception\ClientException;
use CKPL\Pay\Exception\Definition\PaymentException;
use CKPL\Pay\Exception\EndpointException;
use CKPL\Pay\Exception\Exception;
use Drupal\commerce_conotoxia_pay\Exceptions\PaymentResponseException;
use Drupal\commerce_conotoxia_pay\Plugin\Commerce\ConotoxiaPayment;
use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_payment\Exception\PaymentGatewayException;
use Drupal\commerce_payment\PluginForm\PaymentOffsiteForm as BasePaymentOffsiteForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides the Conotoxia Off-site payment form.
 */
class ConotoxiaPaymentForm extends BasePaymentOffsiteForm
{
    /**
     * {@inheritdoc}
     */
    public function buildConfigurationForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildConfigurationForm($form, $form_state);

        /** @var array $key_table */
        $key_table = [
            'merchant_id',
            'merchant_secret',
            'pos_id',
            'public_rsa_key',
            'private_rsa_key',
            'host',
            'oidc',
        ];

        /** @var \Drupal\commerce_payment\Entity\PaymentInterface $payment */
        $payment = $this->entity;

        /** @var \Drupal\commerce_payment\Plugin\Commerce\PaymentGateway\OffsitePaymentGatewayInterface $payment_gateway_plugin */
        $payment_gateway_plugin = $payment->getPaymentGateway()->getPlugin();

        $order_id = \Drupal::routeMatch()->getParameter('commerce_order')->id();
        /** @var \Drupal\commerce_order\Entity\Order $order */
        $order = Order::load($order_id);

        /** @var \Drupal\address\Plugin\Field\FieldType\AddressItem $address */
        $address = $order->getBillingProfile()->address->first();

        foreach ($key_table as $key) {
            $conotoxia_pay_config[$key] = $payment_gateway_plugin->getConfiguration()[$key];
        }
        $notification_url = Url::fromRoute(
            'commerce_payment.notify',
            ['commerce_payment_gateway' => $payment->getPaymentGateway()->id()],
            ['absolute' => true]
        )->toString();
        $return_url = $form['#return_url'];
        $error_url = $form['#cancel_url'];

        try {
            $conotoxia_payment = new ConotoxiaPayment($conotoxia_pay_config);
            $conotoxia_payment_response = $conotoxia_payment->paymentProcess(
                $order,
                $address,
                $return_url,
                $error_url,
                $notification_url
            );

            if (!empty($conotoxia_payment_response)) {
                return $this->buildRedirectForm($form, $form_state, $conotoxia_payment_response->getApproveUrl(), $conotoxia_pay_config, BasePaymentOffsiteForm::REDIRECT_GET);
            } else {
                throw new PaymentResponseException();
            }
        } catch (EndpointException | PaymentException | ClientException | Exception $e) {
            throw new PaymentGatewayException($e->getMessage());
        }
    }
}
