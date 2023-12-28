<?php

namespace Johhann\Telebirr;

use Johhann\Telebirr\Services\CallbackService;
use Johhann\Telebirr\Services\EncryptService;

/**
 * Telebirr Class
 *
 * Represents a class for handling Telebirr payment methods.
 */
class Telebirr
{
    /**
     * Get Payment Method
     *
     * Returns the name of the payment method (Telebirr).
     *
     * @return string The name of the payment method.
     */
    public static function getPaymentMethod(): string
    {
        return 'Telebirr';
    }

    /**
     * Make Method
     *
     * Initiates the encryption process using the EncryptService to prepare payment data for Telebirr.
     *
     * @param  float  $amount The amount of the transaction.
     * @param  string  $invoice The invoice or transaction identifier.
     * @param  string|null  $subject The subject or description of the transaction (optional).
     * @return array|null The encrypted data for Telebirr payment or null if encryption fails.
     */
    public function make($amount, $invoice, $subject = null): ?array
    {
        // Use EncryptService to handle the encryption of payment data
        return (new EncryptService())->handle($amount, $invoice, $subject);
    }

    /**
     * Callback Method
     *
     * Initiates the decryption process using the CallbackService to retrieve decrypted data.
     *
     * @return array The decrypted data obtained from the CallbackService.
     */
    public function callback(): array
    {
        // Use CallbackService to handle the decryption process
        return (new CallbackService())->handle();
    }
}
