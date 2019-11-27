<?php

return [
    /**
     * Path to your serviceAccountKey.json file
     * By default, path to the json key file is defined in one of the following environment variable
     *
     *   FIREBASE_CREDENTIALS
     *   GOOGLE_APPLICATION_CREDENTIALS
     *
     * Or, located on the Google's well known path
     *
     *  Linux: $HOME/.config/gcloud/application_default_credentials.json
     *   Windows: $APPDATA/gcloud/application_default_credentials.json
     *
     * Left this value empty to auto discover the json key file.
     */
    'firebase_credentials' => env('FIREBASE_CREDENTIALS', ''),

    /**
     * Android message settings
     */
    'android' => [
        'ttl' => '3600s',
        'priority' => 'high'
    ],
    
    /**
     * APNs (iOS) message settings
     */
    'apns' => [
        'headers' => [
            'apns-priority' => '10'
        ]
    ],
];