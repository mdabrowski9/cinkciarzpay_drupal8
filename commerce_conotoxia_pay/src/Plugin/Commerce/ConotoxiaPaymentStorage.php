<?php

namespace Drupal\commerce_conotoxia_pay\Plugin\Commerce;

use CKPL\Pay\Storage\AbstractStorage;
use CKPL\Pay\Storage\StorageInterface;

/**
 * Class ConotoxiaPaymentStorage.
 */
class ConotoxiaPaymentStorage extends AbstractStorage
{
    /**
     * @type string
     */
    const STORAGE_CONFIG = 'conotoxia_payment_storage.settings';

    /**
     * @var string
     */
    const CONFIG_TEXT = 'configure.';

    /**
     * ConotoxiaPaymentStorage constructor.
     */
    public function __construct()
    {
        $this->items = [];

        $this->load();
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasItem(string $key): bool
    {
        return \array_key_exists($key, $this->items);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function setItem(string $key, $value): void
    {
        /** @var \Drupal\Core\Config\Config $config */
        $config = \Drupal::configFactory()->getEditable(static::STORAGE_CONFIG);
        if (StorageInterface::TOKEN === $key || StorageInterface::PAYMENT_SERVICE_PUBLIC_KEYS === $key) {
            $config->set(
                self::CONFIG_TEXT . $key,
                json_encode($value, JSON_PRESERVE_ZERO_FRACTION | JSON_UNESCAPED_SLASHES)
            );

            $this->items[$key] = $value;
        } else {
            $config->set(self::CONFIG_TEXT . $key, (string) $value);

            $this->items[$key] = (string) $value;
        }
        $config->save();
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $config = \Drupal::configFactory()->getEditable(static::STORAGE_CONFIG);
        $config->clear(self::CONFIG_TEXT . StorageInterface::PAYMENT_SERVICE_PUBLIC_KEYS)->save();
        $config->clear(self::CONFIG_TEXT . StorageInterface::PUBLIC_KEY_CHECKSUM)->save();
        $config->clear(self::CONFIG_TEXT . StorageInterface::PUBLIC_KEY_ID)->save();
        $config->clear(self::CONFIG_TEXT . StorageInterface::TOKEN)->save();
    }

    /**
     * @return void
     */
    protected function load(): void
    {
        $array_items = [StorageInterface::TOKEN, StorageInterface::PAYMENT_SERVICE_PUBLIC_KEYS];
        $string_items = [StorageInterface::PUBLIC_KEY_ID, StorageInterface::PUBLIC_KEY_CHECKSUM];

        foreach ($array_items as $array_item) {
            if (!empty(\Drupal::config(static::STORAGE_CONFIG)->get(self::CONFIG_TEXT . $array_item))) {
                $this->items[$array_item] = json_decode(\Drupal::config(static::STORAGE_CONFIG)->get(self::CONFIG_TEXT . $array_item),
                    true
                );
            }
        }

        foreach ($string_items as $string_item) {
            if (!empty(\Drupal::config(static::STORAGE_CONFIG)->get(self::CONFIG_TEXT . $string_item))) {
                $this->items[$string_item] = \Drupal::config(static::STORAGE_CONFIG)->get(self::CONFIG_TEXT . $string_item);
            }
        }
    }
}
