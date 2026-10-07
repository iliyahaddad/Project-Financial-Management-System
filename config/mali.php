<?php

return [
    'app_name' => env('APP_NAME', 'Mali'),
    'default_currency' => env('DEFAULT_CURRENCY', 'IRR'),
    'available_currencies' => [
        'IRR' => 'ریال',
        'USD' => 'دلار آمریکا',
        'EUR' => 'یورو',
    ],
    'currency_symbol' => env('CURRENCY_SYMBOL', 'ریال'),
    'date_format' => env('DATE_FORMAT', 'Y/m/d'),
    'persian_months' => [
        'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور',
        'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'
    ],
    'upload_max_size' => 10240,
    'allowed_mimes' => ['pdf','doc','docx','xls','xlsx','jpg','jpeg','png','zip'],
    'pagination_per_page' => 15,
    'thresholds' => [
        'progress_warning' => -5,
        'progress_critical' => -10,
        'cost_warning' => 5,
        'cost_critical' => 10,
        'man_day_warning' => 1.00,
        'man_day_critical' => 1.15,
        'profit_warning' => 25,
        'profit_critical' => 15,
    ],
];
