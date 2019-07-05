<?php

namespace Drupal\commerce_conotoxia_pay;

class ConotoxiaPayStorage
{
  /** @var string */
  const TABLE_NAME = 'commerce_conotoxia_pay';

  /** @var string */
  const COLUMN_ORDER_ID = 'order_id';

  /** @var string */
  const COLUMN_CONOTOXIAPAY_ID = 'conotoxiapay_id';

  /** @var string */
  const COLUMN_CONOTOXIAPAY_STATUS = 'conotoxiapay_status';

  /** @var string */
  const COLUMN_PAYMENT_CREATED_DATE = 'payment_created_date';

  /** @var string */
  const COLUMN_PAYMENT_CONFIRM_DATE = 'payment_confirm_date';

  /** @var string */
  const DATE_FORMAT = 'Y-m-d H:i:s';

  /**
   * @param int $order_id
   * @param string $conotoxia_pay_id
   * @param string $conotoxia_pay_status
   * @throws \Exception
   */
    public static function addData(int $order_id, string $conotoxia_pay_id, string $conotoxia_pay_status)
    {
        \Drupal::database()->insert(self::TABLE_NAME)->fields(
            [
                self::COLUMN_ORDER_ID => (int)$order_id,
                self::COLUMN_CONOTOXIAPAY_ID => $conotoxia_pay_id,
                self::COLUMN_CONOTOXIAPAY_STATUS => $conotoxia_pay_status,
                self::COLUMN_PAYMENT_CREATED_DATE => date(self::DATE_FORMAT),
            ]
        )->execute();
    }

    /**
     * @param int $order_id
     * @param string $conotoxia_pay_id
     * @param string $conotoxia_pay_status
     * @param string $payment_created_date
     * @param string $payment_confirm_date
     */
    public static function editData(
        int $order_id,
        string $conotoxia_pay_id,
        string $conotoxia_pay_status,
        string $payment_created_date,
        string $payment_confirm_date
    ) {
        \Drupal::database()
            ->update(self::TABLE_NAME)
            ->fields([
                self::COLUMN_ORDER_ID => (int)$order_id,
                self::COLUMN_CONOTOXIAPAY_ID => $conotoxia_pay_id,
                self::COLUMN_CONOTOXIAPAY_STATUS => $conotoxia_pay_status,
                self::COLUMN_PAYMENT_CREATED_DATE => $payment_created_date,
                self::COLUMN_PAYMENT_CONFIRM_DATE => $payment_confirm_date,
            ])
            ->condition(self::COLUMN_ORDER_ID, $order_id, '=')
            ->execute();
    }

    /**
     * @param int $order_id
     * @param string $conotoxia_pay_status
     */
    public static function setConotoxiaPayStatus(int $order_id, string $conotoxia_pay_status)
    {
        \Drupal::database()
            ->update(self::TABLE_NAME)
            ->fields([
                self::COLUMN_CONOTOXIAPAY_STATUS => $conotoxia_pay_status,
                self::COLUMN_PAYMENT_CONFIRM_DATE => \date(self::DATE_FORMAT),
            ])
            ->condition(self::COLUMN_ORDER_ID, $order_id, '=')
            ->execute();
    }

    /**
     * @param int $order_id
     *
     * @return array
     */
    public static function getConotoxiaPayId(int $order_id): array
    {
        $query = \Drupal::database()
            ->select(self::TABLE_NAME, 'ccp')
            ->condition(self::COLUMN_ORDER_ID, $order_id, '=')
            ->fields('ccp', [self::COLUMN_CONOTOXIAPAY_ID])
            ->execute()
            ->fetchCol();

        return $query[self::COLUMN_CONOTOXIAPAY_ID];
    }

    /**
     * @param int $order_id
     *
     * @return bool
     */
    public static function isEditableRow(int $order_id): bool
    {
        $query = \Drupal::database()
            ->select(self::TABLE_NAME, 'ccp')
            ->condition(self::COLUMN_ORDER_ID, $order_id, '=')
            ->fields('ccp', ['id', self::COLUMN_ORDER_ID, self::COLUMN_CONOTOXIAPAY_ID])
            ->execute()
            ->fetchCol(2);
        if (empty($query)) {
            return false;
        }

        return true;
    }
}
