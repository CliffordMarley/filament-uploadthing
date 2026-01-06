<?php

return [
    /*
    |--------------------------------------------------------------------------
    | UploadThing API Key
    |--------------------------------------------------------------------------
    |
    | Your UploadThing API key. Get it from https://uploadthing.com/dashboard
    |
    */
    'api_key' => env('UPLOADTHING_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Default Endpoint
    |--------------------------------------------------------------------------
    |
    | The default UploadThing endpoint to use for uploads
    |
    */
    'default_endpoint' => env('UPLOADTHING_ENDPOINT', 'imageUploader'),

    /*
    |--------------------------------------------------------------------------
    | Max File Size
    |--------------------------------------------------------------------------
    |
    | Maximum file size in bytes (default: 10MB)
    |
    */
    'max_file_size' => 10 * 1024 * 1024, // 10MB
];