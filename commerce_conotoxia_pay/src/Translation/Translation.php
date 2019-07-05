<?php

declare(strict_types=1);

namespace Drupal\commerce_conotoxia_pay\Translation;

/**
 * Class Translation
 * @package Drupal\commerce_conotoxia_pay\Translation
 */
class Translation
{
    /** @var string */
    public const HOST_PARAMETER_EXCEPTION = 'Błędny Host lub OIDC';

    /** @var string */
    public const PAYMENT_RESPONSE_EXCEPTION = 'Błąd w zapytaniu lub odpowiedzi z Cinkciarz Pay.';

    /** @var string */
    public const ADMIN_FORM_MERCHANT_ID_TITLE = 'Numer ID klienta';

    /** @var string */
    public const ADMIN_FORM_MERCHANT_ID_DESCRIPTION = 'Numer ID klienta (ID w systemie FX.web - w panelu merchanta).';

    /** @var string */
    public const ADMIN_FORM_MERCHANT_SECRET_TITLE = 'Hasło klienta';

    /** @var string */
    public const ADMIN_FORM_MERCHANT_SECRET_DESCRIPTION = 'Hasło klienta (Parametr uwierzytelniający otrzymywany przy tworzeniu merchanta w systemie FX.web).';

    /** @var string */
    public const ADMIN_FORM_POS_ID_TITLE = 'ID punktu płatności';

    /** @var string */
    public const ADMIN_FORM_POS_ID_DESCRIPTION = 'ID punktu płatności (ID punktu płatności w panelu merchanta).';

    /** @var string */
    public const ADMIN_FORM_PUBLIC_RSA_KEY_TITLE = 'Klucz publiczny RSA';

    /** @var string */
    public const ADMIN_FORM_PUBLIC_RSA_KEY_DESCRIPTION = 'Klucz publiczny do podpisów cyfrowych każdej transakcji.';

    /** @var string */
    public const ADMIN_FORM_PRIVATE_RSA_KEY_TITLE = 'Klucz prywatny RSA';

    /** @var string */
    public const ADMIN_FORM_PRIVATE_RSA_KEY_DESCRIPTION = 'Klucz prywatny do odbierania wiadomości z systemu płatności.';

    /** @var string */
    public const VALIDATE_SUCCESS_MESSAGE = 'Cinkciarz\'s credentials was successfully saved';
}
