<?php

if (!function_exists('format_currency')) {
    function format_currency(float|int $amount, ?string $currency = null): string {
        $currency = $currency ?? config('mali.currency_symbol', 'ریال');
        return number_format($amount) . ' ' . $currency;
    }
}

if (!function_exists('persian_date')) {
    function persian_date(string $date, ?string $format = null): string {
        $format = $format ?? 'Y/m/d';
        $timestamp = strtotime($date);
        $jdate = \Morilog\Jalali\Jalalian::fromDateTime($timestamp)->format($format);
        return $jdate;
    }
}

if (!function_exists('persian_number')) {
    function persian_number($number): string {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        return str_replace(range(0,9), $persian, $number);
    }
}

if (!function_exists('status_label')) {
    function status_label(string $status): string {
        return match($status) {
            'normal' => 'عادی',
            'warning' => 'هشدار',
            'critical' => 'بحرانی',
            'draft' => 'پیش‌نویس',
            'active' => 'فعال',
            'suspended' => 'متوقف',
            'completed' => 'خاتمه‌یافته',
            'cancelled' => 'فسخ‌شده',
            'pending_start' => 'در انتظار شروع',
            default => $status,
        };
    }
}
