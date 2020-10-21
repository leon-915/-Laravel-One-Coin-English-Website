<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'client_id' => env('STRIPE_CLIENT_ID', 'ca_GgphohQHW325a5TM8x7VfHgekssrezBG'),
        'test_secret_key' => env('TEST_SECRET_KEY', 'sk_test_n3mVkiCkZcadFjKWjR8JjL0s00gs1XQiyK'),
        'test_Publishable_key' => env('TEST_PUBLISHABLE_KEY', 'pk_test_sruVeRX5MmfbfkTABSYWzbJV00OSvdhegr'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'facebook' => [
        'app_id' => env('FACEBOOK_APP_ID', '147513489753564'),         // Your Facebook App Client ID
        'app_secret' => env('FACEBOOK_APP_SECRET', 'c4932c52135cceb581b7c9b7e3350921'), // Your Facebook App Client Secret
        'page_id' => env('FACEBOOK_PAGE_ID', '111878760382985'), // Your Facebook App Client Secret
        'access_token' => env('FACEBOOK_ACCESS_TOKEN', 'EAACGKakoBdwBAA3VmJE0lXe7mejEHehySYcFP8HXWnUlpsecDvNgD4fLLCOQoKybrLQmZATIk1Fy7CL6JFhZAISqGYJuzTzPDMHZBpMSkY9XjEl8qGkrkmSVD8CfUHGInFhbsIJrNibeH0kBK7nHQu2S4RM3UXlloUdIBMo7d50q2XKYfU10poNJHjRhTQZD'),
        'default_graph_version' => 'v2.12',
    ],

    'zcrm' => [
        'zoho_client_id' => env('ZOHO_CLIENT_ID', '1000.P7YUVI8DG0HKMKZWQ1QY86KJ34E1GH'), 
        'zoho_client_secret' => env('ZOHO_CLIENT_SECRET', 'deeefc1a1f1b9a84fd5eb49e74e3765ffe672323dd'),
		'zoho_refresh_token' => '1000.37bb3b16b3a61f969afc7b234a58fb1d.c658fc0d1601dca2e73c4fcabcb9a7fd',
		'zoho_redirect_uri' => 'https://lokalingo.com',
		'zoho_org_id' => '702168137',
		'zoho_tax_id' => '2102930000000071038',
		'zoho_currency_id' => '2102930000000000111',
    ],

    'google' => [
        'google_api_key' => env('GOOGLE_API_KEY', 'AIzaSyDqxjEfLVCgHXTLHfwcbEqSjk3cmzqc6ME'), 
        'recaptcha_key' => env('GOOGLE_RECAPTCHA_KEY', '6LfdgeAUAAAAAIcbzokKissJwALLfLhupu2f8a77'), 
        'recaptcha_secret' => env('GOOGLE_RECAPTCHA_SECRET', '6LfdgeAUAAAAAKrPefyH1LPonmMr7vD6Cu244o3I'), 
    ],

    'mailerlite' => [
        'api_key' => env('MAILERLITE_API_KEY', '5171f546f9119880f596265767101bff'), 
        'student_group_id' => env('STUDENT_GROUP_ID', '91165404'), 
        'teacher_group_id' => env('TEACHER_GROUP_ID', '91491648'), 
    ],

];
