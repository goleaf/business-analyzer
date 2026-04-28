<?php

return [
    'admin_user_email' => env('ADMIN_USER_EMAIL', 'admin@example.com'),
    'admin_email' => env('ADMIN_EMAIL', 'admin@example.com'),

    'ai_smoke_test' => [
        'provider' => env('AI_SMOKE_TEST_PROVIDER', 'openai'),
        'model' => env('AI_SMOKE_TEST_MODEL'),
        'timeout' => (int) env('AI_SMOKE_TEST_TIMEOUT', 45),
        'web_search_max' => (int) env('AI_SMOKE_TEST_WEB_SEARCH_MAX', 3),
    ],
];
