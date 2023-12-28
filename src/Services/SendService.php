<?php

namespace Johhann\Telebirr\Services;

use Illuminate\Support\Facades\Http;

/**
 * SendService Class
 *
 * Represents a final class responsible for sending data to telebirr server.
 * Instances of this class cannot be further extended by other classes.
 */
final class SendService
{
    private $appId;

    private $webUrl;

    /**
     * Constructor for the class.
     *
     * Initializes the SendService instance by setting configuration values.
     */
    public function __construct()
    {
        // Set the application ID and web URL from configuration
        $this->appId = config('telebirr.app_id');
        $this->webUrl = config('telebirr.web_url');
    }

    /**
     * Handle method
     *
     * Sends a POST request to the telebirr web URL with the provided sign and encrypted USSD JSON.
     *
     * @param  string  $sign The signature associated with the data.
     * @param  string  $encryptedUSSDJson The encrypted USSD JSON data.
     * @return array The response received from the HTTP POST request.
     */
    public function handle($sign, $encryptedUSSDJson): ?array
    {
        // Perform an HTTP POST request with the specified headers and data
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json;charset=utf-8',
        ];

        $data = [
            'appid' => $this->appId,
            'sign' => $sign,
            'ussd' => $encryptedUSSDJson,
        ];

        $ch = curl_init($this->webUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error: '.curl_error($ch);
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}
