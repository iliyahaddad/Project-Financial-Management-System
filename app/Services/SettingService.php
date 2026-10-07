<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    private string $table = 'settings';

    public function get(string $key, mixed $default = null): mixed
    {
        $value = Cache::get("setting:{$key}");

        if ($value !== null) {
            return $this->castValue($value);
        }

        $record = DB::table($this->table)->where('key', $key)->first();

        if (!$record) {
            return $default;
        }

        Cache::put("setting:{$key}", $record->value, now()->addHours(2));

        return $this->castValue($record->value);
    }

    public function set(string $key, mixed $value, ?string $type = 'string', ?string $group = null, ?string $description = null): void
    {
        DB::transaction(function () use ($key, $value, $type, $group, $description) {
            DB::table($this->table)->updateOrInsert(
                ['key' => $key],
                [
                    'value' => $this->serializeValue($value, $type),
                    'type' => $type,
                    'group' => $group,
                    'description' => $description,
                    'updated_at' => now(),
                    'created_at' => DB::raw('COALESCE(created_at, ?)', [now()]),
                ]
            );

            Cache::forget("setting:{$key}");
        });
    }

    public function getGroup(string $group): array
    {
        $settings = DB::table($this->table)
            ->where('group', $group)
            ->get()
            .keyBy('key');

        return $settings->map(fn($item) => $this->castValue($item->value))->toArray();
    }

    public function getThresholds(): array
    {
        $keys = [
            'progress_warning_threshold',
            'progress_critical_threshold',
            'cost_warning_threshold',
            'cost_critical_threshold',
            'man_day_warning_ratio',
            'man_day_critical_ratio',
            'min_profit_margin_warning',
            'min_profit_margin_critical',
        ];

        $defaults = [
            'progress_warning_threshold' => -5,
            'progress_critical_threshold' => -10,
            'cost_warning_threshold' => 5,
            'cost_critical_threshold' => 10,
            'man_day_warning_ratio' => 1.00,
            'man_day_critical_ratio' => 1.15,
            'min_profit_margin_warning' => 25,
            'min_profit_margin_critical' => 15,
        ];

        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->get($key, $defaults[$key]);
        }

        return $result;
    }

    public function getCurrencyConfig(): array
    {
        return [
            'symbol' => $this->get('currency_symbol', 'ریال'),
            'code' => $this->get('currency_code', 'IRR'),
        ];
    }

    public function resetToDefaults(): void
    {
        DB::transaction(function () {
            DB::table($this->table)->truncate();

            $defaults = [
                'progress_warning_threshold' => -5,
                'progress_critical_threshold' => -10,
                'cost_warning_threshold' => 5,
                'cost_critical_threshold' => 10,
                'man_day_warning_ratio' => 1.00,
                'man_day_critical_ratio' => 1.15,
                'min_profit_margin_warning' => 25,
                'min_profit_margin_critical' => 15,
                'currency_symbol' => 'ریال',
                'currency_code' => 'IRR',
                'company_name' => 'شرکت بازرسی پیمانکاری',
            ];

            foreach ($defaults as $key => $value) {
                $this->set($key, $value);
            }
        });
    }

    private function castValue(mixed $value): mixed
    {
        if (is_numeric($value) && floor($value) == $value) {
            return (int) $value;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        return $value;
    }

    private function serializeValue(mixed $value, string $type): string
    {
        if ($type === 'json') {
            return json_encode($value);
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value);
        }

        return (string) $value;
    }
}
