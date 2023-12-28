<?php

namespace Johhann\Telebirr\Services;

/**
 * DecryptService Class
 *
 * Extends the BaseService class and provides final implementation for decrypting data for telebirr callback response.
 * This class cannot be further extended by other classes.
 *
 * @extends BaseService
 */
final class DecryptService extends BaseService
{
    /**
     * Constructor for the class
     *
     * Calls the constructor of the parent class for any necessary initialization.
     */
    public function __construct()
    {
        // Call the constructor of the parent class
        parent::__construct();
    }

    /**
     * Handle Method
     *
     * Processes the incoming request data, splits it, and initiates the decryption process.
     *
     * @return array The decrypted data obtained from the decryption process.
     */
    public function handle(): array
    {
        // Get the content of the incoming request
        $data = request()->getContent();

        // Split the data using a custom method
        $formattedData = self::splitData($data);

        // Initiate the decryption process and obtain the decrypted data
        return self::makeDecryption($formattedData);
    }

    /**
     * makeDecryption Method
     *
     * Performs the decryption of formatted data chunks using the OpenSSL public key.
     *
     * @param  array  $formattedData An array of formatted data chunks to be decrypted.
     * @return array The decrypted data obtained from the decryption process.
     */
    private static function makeDecryption($formattedData): array
    {
        // Initialize an empty string to store the decrypted data
        $decrypted = '';

        // Iterate over each formatted data chunk and decrypt using the OpenSSL public key
        foreach ($formattedData as $chunk) {
            $partial = '';
            // Attempt to decrypt the chunk using the public key
            $decryptionOK = openssl_public_decrypt($chunk, $partial, parent::$publicKey, OPENSSL_PKCS1_PADDING);

            // If decryption fails, exit with an error message
            if ($decryptionOK === false) {
                exit('fail');
            }
            // Concatenate the decrypted partial data
            $decrypted .= $partial;
        }

        // Decode the decrypted string as JSON and return the resulting array
        return json_decode($decrypted, true);
    }

    /**
     * splitData Method
     *
     * Splits base64-encoded data into chunks of a specified length (256 bytes).
     *
     * @param  string  $data The base64-encoded data to be split.
     * @return array An array of data chunks obtained from the splitting process.
     */
    public static function splitData($data): array
    {
        // Split the base64-decoded data into chunks of 256 bytes
        return str_split(base64_decode($data), 256);
    }
}
