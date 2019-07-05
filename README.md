# Introduction
Plugin for Drupal 8 that implements Cinkciarz Pay as payment method using Drupal Commerce and Drupal Commerce Payment module.

# Installation
Plugin should be installed manually. Just copy commerce_cinkciarz_pay directory to suitable localization (e.g `"drupal_estore_project"/web/modules`)

## Manual

> How to clone repository

```bash
git clone https://stash.cin.pl/scm/gp/php-pay-drupal-8.git
```

1. Clone repository with plugin.
2. Upload `commerce_cinkciarz_pay` to suitable directory (e.g `"drupal_estore_project"/web/modules`).

# Configuration
1. Go to Drupal `Extend` panel.
2. Enter `List` section.
3. Look for `Commerce Cinkciarz Pay` on commerce plugin list.
4. Click `checkbox` button next to `Commerce Cinkciarz Pay` plugin.
5. Scroll to the end on page and press `Install` button.
6. Go to `Commerce->Configuration->Payment->Payment Gateways`
7. Add CinkciarzPay payment gateway, fill all text fields in form (all are required).
8. Save Payment Gateway.
9. That's it. Now you can use Cinkciarz Pay as method of Payments.

# Sandbox
1. Go to `Commerce->Configuration->Payment->Payment Gateways`.
2. Look for `Cinkciarz Pay` on payment gateways list.
3. Click `Edit` button next to `Cinkciarz Pay` payment gateway.
4. Choose `Sandbox` button in `Mode` section.
5. Scroll to the end of page and press `Save` button.
6. Now your Cinkciarz Pay plugin work in Sandbox mode.