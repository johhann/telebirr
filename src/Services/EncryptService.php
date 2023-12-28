<?php

namespace Johhann\Telebirr\Services;

/**
 * EncryptService Class
 *
 * Extends the BaseService class and provides final implementation for encrypting data.
 * This class cannot be further extended by other classes.
 *
 * @extends BaseService
 */
final class EncryptService extends BaseService
{
    private string $name;

    private string $nonce;

    private string $appId;

    private string $appKey;

    private string $subject;

    private string $notifyUrl;

    private string $returnUrl;

    private string $shortCode;

    private string $outTradeNo;

    private int $timeoutExpress;

    /**
     * Constructor for the TelebirrService class
     *
     * Initializes the TelebirrService instance by calling the parent constructor,
     * setting default values for various properties, and retrieving configuration values.
     */
    public function __construct()
    {
        // Call the parent class constructor
        parent::__construct();

        // Generate a unique nonce for the transaction
        $this->nonce = uniqid();

        // Set default values for properties using configuration values
        $this->name = config('telebirr.name');
        $this->appId = config('telebirr.app_id');
        $this->appKey = config('telebirr.app_key');
        $this->subject = config('telebirr.subject');
        $this->notifyUrl = config('telebirr.notify_url');
        $this->returnUrl = config('telebirr.return_url');
        $this->timeoutExpress = config('telebirr.timeout_express');

        // Convert short code to an integer (if applicable)
        $this->shortCode = (int) config('telebirr.short_code');
    }

    /**
     * handle method
     *
     * Handles the payment process by generating necessary data, signing it, and encrypting it for USSD transactions.
     *
     * @param  float  $amount The amount of the transaction.
     * @param  string  $invoice The invoice or transaction identifier.
     * @param  string|null  $subject The subject or description of the transaction (optional, defaults to the class property).
     * @return array The result of the USSD transaction handled by the SendService.
     */
    public function handle($amount, $invoice, $subject = null): ?array
    {
        // Set the transaction identifier
        $this->outTradeNo = $invoice;

        // If a custom subject is provided, use it; otherwise, use the default subject from the class property
        $subject = $subject ?? $this->subject;

        // Get data for the payment transaction
        $data = $this->getData($amount, $subject);

        // Convert data to StringA
        $stringA = $this->getStringA($data);

        // Get StringB by hashing StringA
        $StringB = $this->getStringB($stringA);

        // Get sign from uppercase StringB format
        $sign = $this->getUpperStringB($StringB);

        // Get USSDJson representation of the data
        $USSDJson = $this->getUSSDJson($data);

        // Encrypt USSDJson for secure transmission
        $encryptUSSDJson = $this->encryptUSSDJson($USSDJson);

        // Delegate the handling of the signed and encrypted data to the SendService
        return (new SendService())->handle($sign, $encryptUSSDJson);
    }

    /**
     * getData method
     *
     * Constructs an associative array containing data for a payment transaction.
     *
     * @param  float  $amount The amount of the transaction.
     * @param  string  $subject The subject or description of the transaction.
     * @return array The array containing data for the payment transaction.
     */
    private function getData($amount, $subject)
    {
        // Prepare data for the payment transaction
        $data = [
            'subject' => $subject,
            'appId' => $this->appId,
            'nonce' => $this->nonce,
            'appKey' => $this->appKey,
            'receiveName' => $this->name,
            'notifyUrl' => $this->notifyUrl,
            'returnUrl' => $this->returnUrl,
            'shortCode' => $this->shortCode,
            'totalAmount' => (float) $amount,
            'outTradeNo' => $this->outTradeNo,
            'timeoutExpress' => $this->timeoutExpress,
            'timestamp' => strtotime(date('Y-m-d H:i:s')),
        ];

        // Sort the data array by key
        ksort($data);

        return $data;
    }

    /**
     * getStringA method
     *
     * This method takes an associative array $data and constructs a query string
     * by concatenating key-value pairs with '=' between keys and values, and '&' between pairs.
     *
     * @param  array  $data An associative array containing data to be converted to a query string.
     * @return string The generated query string.
     */
    private function getStringA($data)
    {
        $stringA = '';

        foreach ($data as $k => $v) {
            $stringA == '' ? ($stringA = $k.'='.$v) : ($stringA = $stringA.'&'.$k.'='.$v);
        }

        return $stringA;
    }

    /**
     * getStringB method
     *
     * Generates a SHA-256 hash of the input string.
     *
     * @param  string  $stringA The input string to be hashed.
     * @return string The SHA-256 hash of the input string.
     */
    private function getStringB($stringA)
    {
        // Use the SHA-256 algorithm to hash the stringA
        return hash('sha256', $stringA);
    }

    /**
     * getUpperStringB method
     *
     * Converts the input string to uppercase.
     *
     * @param  string  $StringB The input string to be converted to uppercase.
     * @return string The input string converted to uppercase.
     */
    private function getUpperStringB($StringB)
    {
        // Use the strtoupper function to convert the stringB to uppercase
        return strtoupper($StringB);
    }

    /**
     * getUSSDJson method
     *
     * Encodes an associative array into a JSON string.
     *
     * @param  array  $data The associative array to be encoded into JSON.
     * @return string The JSON representation of the input array.
     */
    private function getUSSDJson($data)
    {
        // Use the json_encode function to convert the associative array to a JSON string
        return json_encode($data);
    }

    /**
     * encryptUSSDJson method
     *
     * Encrypts a JSON string using public key encryption and returns the base64-encoded result.
     *
     * @param  string  $USSDJson The JSON string to be encrypted.
     * @return string The base64-encoded encrypted representation of the input JSON string.
     *                Returns 'fail' if encryption fails.
     */
    private function encryptUSSDJson($USSDJson)
    {
        // Initialize an empty string to store the encrypted chunks
        $encryptedUSSDJson = '';

        // Encrypt the JSON string in chunks using OpenSSL public key encryption
        foreach (str_split($USSDJson, 117) as $chunk) {
            // Attempt to encrypt the chunk using the public key
            $data = openssl_public_encrypt($chunk, $cryptoItem, parent::$publicKey);

            // If encryption fails, return 'fail'
            if (! $data) {
                return 'fail';
            }

            // Concatenate the encrypted chunk to the result
            $encryptedUSSDJson .= $cryptoItem;
        }

        // Return the base64-encoded result of the encrypted JSON string
        return base64_encode($encryptedUSSDJson);
    }
}
