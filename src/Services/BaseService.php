<?php

namespace Johhann\Telebirr\Services;

class BaseService
{
    protected static $publicKey;

    /**
     * Constructor for the class
     *
     * Initializes the TelebirrService instance by setting the public key, formatting it,
     * and validating its correctness.
     *
     * Note: Assumes the public key is provided in the application's configuration (config/telebirr.php).
     * If the public key is missing or incorrect, this constructor may throw an exception.
     */
    public function __construct()
    {
        // Set the public key from the application's configuration
        self::$publicKey = config('telebirr.public_key');

        // Format the public key as needed for further processing
        $this->getFormattedPublicKey();

        // Validate the correctness of the public key
        $this->validatePublicKey();
    }

    /**
     * getFormattedPublicKey method
     *
     * Formats the provided public key by adding PEM headers and converting it to a valid OpenSSL public key resource.
     */
    private function getFormattedPublicKey(): void
    {
        // Check if a valid public key is present
        if (!self::$publicKey) {
            // If not, throw an exception with an error message
            throw new \RuntimeException('Invalid public key');
        }

        // Break the public key into chunks of 64 characters with newline characters
        $pubPem = chunk_split(self::$publicKey, 64, "\n");

        // Add PEM headers to the formatted public key
        $pubPem = "-----BEGIN PUBLIC KEY-----\n" . $pubPem . "-----END PUBLIC KEY-----\n";

        // Convert the formatted public key to an OpenSSL public key resource
        self::$publicKey = openssl_pkey_get_public($pubPem);
    }

    /**
     * validatePublicKey method
     *
     * Validates the presence of a valid public key. If the public key is missing or invalid,
     * the method exits the application with an error message.
     */
    private function validatePublicKey(): void
    {
        // Check if a valid public key is present
        if (!self::$publicKey) {
            // If not, exit the application with an error message
            throw new \RuntimeException('Invalid public key');
        }
    }
}
