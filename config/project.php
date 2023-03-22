<?php

return [

    'queue_enabled' => env('LETT_QUEUE_ENABLED', true),

    'max_allowed_exception' => env('LETT_MAX_ALLOWED_EXCEPTION', 3000),

    'rotate_exceptions_enabled' => env('LETT_ROTATE_EXCEPTIONS_ENABLED', true),

    'rotate_exceptions_day' => env('LETT_ROTATE_EXCEPTIONS_DAY', 30),

    'exception_email_enabled' => env('LETT_EXCEPTION_EMAIL_ENABLED', true),

];
