<?php

return [

    /**
     * Indicates the transaction receiver name.
     */
    'name' => env('TELEBIRR_NAME', 'TELEBIRR'),

    /**
     * Indicates third party  Short Code provided from telebirr.
     */
    'short_code' => env('TELEBIRR_SHORT_CODE'),

    /**
     *Indicates the appKey provided by telebirr platform
     */
    'app_key' => env('TELEBIRR_APP_KEY'),

    /**
     * Indicates the appID provided from telebirr platform.
     * It uniquely identify the third party.
     */
    'app_id' => env('TELEBIRR_APP_ID'),

    /**
     * Indicates the end point URL from third party which will be used by telebirr platform to respond the Payment result.
     * Telebirr platform uses this third party end point to proactively notify third party server for payment request result.
     * If this parameter is empty, payment result  notification will not be sent.
     */
    'notify_url' => env('TELEBIRR_NOTIFY_URL'),

    /**
     * Indicates third party redirect page URL after the payment completed.
     */
    'return_url' => env('TELEBIRR_RETURN_URL'),

    /**
     * Indicates the public key provided from telebirr platform.
     */
    'public_key' => env('TELEBIRR_PUBLIC_KEY'),

    /**
     * Indicates the timeout to control how long the payment will be available.
     */
    'timeout_express' => env('TELEBIRR_TIMEOUT_EXPRESS', 30), // in minutes

    /**
     * Indicates the H5 App Payment API URL
     */
    'app_url' => env('TELEBIRR_APP_URL'),

    /**
     * Indicates the H5 Web Payment API URL
     */
    'web_url' => env('TELEBIRR_WEB_URL'),

    /**
     * Indicates the H5 SDK Payment API URL
     */
    'sdk_url' => env('TELEBIRR_SDK_URL'),

    /**
     * Indicates the item or any other name for the payment that is being issued by the customer.
     */
    'subject' => env('TELEBIRR_SUBJECT', env('APP_NAME').'_'.date('Ymd')),

];
