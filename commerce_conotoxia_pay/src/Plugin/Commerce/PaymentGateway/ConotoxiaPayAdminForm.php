<?php

namespace Drupal\commerce_conotoxia_pay\Plugin\Commerce\PaymentGateway;

use CKPL\Pay\Exception\Exception;
use Drupal\commerce_conotoxia_pay\ConotoxiaPayStorage;
use Drupal\commerce_conotoxia_pay\Exceptions\HostParameterException;
use Drupal\commerce_conotoxia_pay\Plugin\Commerce\ConotoxiaPayment;
use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_payment\Annotation\CommercePaymentGateway;
use Drupal\commerce_payment\Plugin\Commerce\PaymentGateway\OffsitePaymentGatewayBase;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\commerce_conotoxia_pay\Translation\Translation as CustomTranslation;

/**
 * Provides the Off-site Redirect payment gateway.
 *
 * @CommercePaymentGateway(
 *   id = "conotoxia_pay_redirect",
 *   label = "ConotoxiaPay",
 *   display_label = "ConotoxiaPay",
 *   modes = {
 *     "test" = @Translation("Sandbox"),
 *     "live" = @Translation("Live"),
 *   },
 *   forms = {
 *     "offsite-payment" = "Drupal\commerce_conotoxia_pay\PluginForm\ConotoxiaPaymentForm",
 *   },
 * )
 */
class ConotoxiaPayAdminForm extends OffsitePaymentGatewayBase
{
    /**
     * @var string
     */
    const PAYMENTS_HOST = 'https://login.cinkciarz.pl/';

    /**
     * @var string
     */
    const OIDC_HOST = 'https://partner.cinkciarz.pl/';

    /**
     * @var string
     */
    const PAYMENTS_HOST_SANDBOX = 'https://pay-api.ckpl.us/';

    /**
     * @var string
     */
    const OIDC_HOST_SANDBOX = 'https://oidc.ckpl.us/';

    /**
     * @var string
     */
    const MODE_PROD = 'live';

    /**
     * @var string
     */
    const MODE_TEST = 'test';

    /**
     * @var string
     */
    const KEY_FORM_TYPE = '#type';

    /**
     * @var string
     */
    const KEY_FORM_TITLE = '#title';

    /**
     * @var string
     */
    const KEY_FORM_MAXLENGTH = '#maxlength';

    /**
     * @var string
     */
    const KEY_FORM_DESCRIPTION = '#description';

    /**
     * @var string
     */
    const KEY_FORM_SIZE = '#size';

    /**
     * @var string
     */
    const KEY_FORM_DEFAULT_VALUE = '#default_value';

    /**
     * @var string
     */
    const KEY_FORM_REQUIRED = '#required';

    /**
     * {@inheritdoc}
     *
     * @return array
     *               An associative array with the default configuration
     */
    public function defaultConfiguration(): array
    {
        return [
            'merchant_id'       => '',
            'merchant_secret'   => '',
            'pos_id'            => '',
            'public_rsa_key'    => '',
            'private_rsa_key'   => '',
        ] + parent::defaultConfiguration();
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     *               The form structure
     */
    public function buildConfigurationForm(array $form, FormStateInterface $form_state): array
    {
        $form = parent::buildConfigurationForm($form, $form_state);

        $form['merchant_id'] = [
            static::KEY_FORM_TYPE => 'textfield',
            static::KEY_FORM_TITLE => $this->t(CustomTranslation::ADMIN_FORM_MERCHANT_ID_TITLE),
            static::KEY_FORM_MAXLENGTH => 64,
            static::KEY_FORM_DESCRIPTION => t(CustomTranslation::ADMIN_FORM_MERCHANT_ID_DESCRIPTION),
            static::KEY_FORM_SIZE => 64,
            static::KEY_FORM_DEFAULT_VALUE => filter_var($this->configuration['merchant_id'], FILTER_SANITIZE_STRING),
            static::KEY_FORM_REQUIRED => true,
        ];
        $form['merchant_secret'] = [
            static::KEY_FORM_TYPE => 'password',
            static::KEY_FORM_TITLE => $this->t(CustomTranslation::ADMIN_FORM_MERCHANT_SECRET_TITLE),
            static::KEY_FORM_MAXLENGTH => 64,
            static::KEY_FORM_DESCRIPTION => t(CustomTranslation::ADMIN_FORM_MERCHANT_SECRET_DESCRIPTION),
            static::KEY_FORM_SIZE => 64,
            static::KEY_FORM_REQUIRED => true,
        ];
        $form['pos_id'] = [
            static::KEY_FORM_TYPE => 'textfield',
            static::KEY_FORM_TITLE => $this->t(CustomTranslation::ADMIN_FORM_POS_ID_TITLE),
            static::KEY_FORM_MAXLENGTH => 64,
            static::KEY_FORM_DESCRIPTION => t(CustomTranslation::ADMIN_FORM_POS_ID_DESCRIPTION),
            static::KEY_FORM_SIZE => 64,
            static::KEY_FORM_DEFAULT_VALUE => filter_var($this->configuration['pos_id'], FILTER_SANITIZE_STRING),
            static::KEY_FORM_REQUIRED => true,
        ];
        $form['public_rsa_key'] = [
            static::KEY_FORM_TYPE => 'textarea',
            static::KEY_FORM_TITLE => $this->t(CustomTranslation::ADMIN_FORM_PUBLIC_RSA_KEY_TITLE),
            static::KEY_FORM_DESCRIPTION => t(CustomTranslation::ADMIN_FORM_PUBLIC_RSA_KEY_DESCRIPTION),
            static::KEY_FORM_DEFAULT_VALUE => filter_var($this->configuration['public_rsa_key'], FILTER_SANITIZE_STRING),
            static::KEY_FORM_REQUIRED => true,
        ];
        $form['private_rsa_key'] = [
            static::KEY_FORM_TYPE => 'textarea',
            static::KEY_FORM_TITLE => $this->t(CustomTranslation::ADMIN_FORM_PRIVATE_RSA_KEY_TITLE),
            static::KEY_FORM_DESCRIPTION => t(CustomTranslation::ADMIN_FORM_PRIVATE_RSA_KEY_DESCRIPTION),
            static::KEY_FORM_DEFAULT_VALUE => filter_var($this->configuration['private_rsa_key'], FILTER_SANITIZE_STRING),
            static::KEY_FORM_REQUIRED => true,
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateConfigurationForm(array &$form, FormStateInterface $form_state): void
    {
        parent::validateConfigurationForm($form, $form_state);
        if ($form_state->getErrors()) {
            return;
        }
        $values = $form_state->getValue($form['#parents']);
        if (empty($values['merchant_id']) || (empty($values['merchant_secret'])) && empty($this->configuration['merchant_secret'])) {
            return;
        }
        $this->messenger()->addMessage($this->t(CustomTranslation::VALIDATE_SUCCESS_MESSAGE));

    }

    /**
     * {@inheritdoc}
     */
    public function submitConfigurationForm(array &$form, FormStateInterface $form_state): void
    {
        parent::submitConfigurationForm($form, $form_state);
        if ($form_state->getErrors()) {
            return;
        }
        $values = $form_state->getValue($form['#parents']);
        $keys = [
            'merchant_id',
            'merchant_secret',
            'pos_id',
            'public_rsa_key',
            'private_rsa_key',
        ];

        foreach ($keys as $key) {
            if (!isset($values[$key])) {
                $values[$key] = $this->configuration[$key];
            }
            $this->configuration[$key] = $values[$key];
        }

        if (self::MODE_PROD === $this->configuration['mode']) {
            $this->configuration['host'] = static::PAYMENTS_HOST;
            $this->configuration['oidc'] = static::OIDC_HOST;
        } elseif (self::MODE_TEST === $this->configuration['mode']) {
            $this->configuration['host'] = static::PAYMENTS_HOST_SANDBOX;
            $this->configuration['oidc'] = static::OIDC_HOST_SANDBOX;
        } else {
            throw new HostParameterException();
        }

        try {
            $conotoxia_payment = new ConotoxiaPayment($this->configuration);
            $conotoxia_payment->savePublicKeyToStorage();
            $conotoxia_payment->setPublicKey();
        } catch (Exception $e) {
            $this->messenger()->addError($this->t($e->getMessage()));

            return;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onNotify(Request $request)
    {
        parent::onNotify($request);
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $input = file_get_contents('php://input');
            try{
                $conotoxia_payment = new ConotoxiaPayment($this->configuration);
            } catch (Exception $e) {
                $this->messenger()->addError($this->t($e->getMessage()));
                return;
            }

            $status = $conotoxia_payment->getConfirmStatus($input);
            $order_id = $conotoxia_payment->getConfirmOrderId($status);
            $order = Order::load($order_id);

            if ($status->isNew()) {
                ConotoxiaPayStorage::addData($order_id, $status->getPaymentId(), 'NEW');
            } elseif ($status->isCompleted() && ConotoxiaPayStorage::getEditableRow($order_id)) {
                ConotoxiaPayStorage::setConotoxiaPayStatus($order_id, 'COMPLETED');
                $order->state = 'completed';
            } elseif ($status->isRejected() && ConotoxiaPayStorage::getEditableRow($order_id)) {
                ConotoxiaPayStorage::setConotoxiaPayStatus($order_id, 'REJECTED');
                $order->state = 'rejected';
            } elseif ($status->isCancelled() && ConotoxiaPayStorage::getEditableRow($order_id)) {
                ConotoxiaPayStorage::setConotoxiaPayStatus($order_id, 'CANCELLED');
                $order->state = 'cancelled';
            } else {
                $this->sendResponse('HTTP/1.1 400 Bad Request', 'ERROR');
            }

            $order->save();
            $this->sendResponse('HTTP/1.1 200 OK', 'OK');
        } else {
            $this->sendResponse('HTTP/1.1 400 Bad Request', 'ERROR');
        }
    }
}
