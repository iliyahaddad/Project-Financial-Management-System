<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'forecast_date',
        'model_type',
        'actual_cost_to_date',
        'actual_progress',
        'budget_cost',
        'etc',
        'eac_system',
        'manual_eac',
        'selected_eac',
        'forecast_profit',
        'forecast_margin',
        'reason_for_override',
        'override_by',
        'override_at',
        'notes',
    ];

    protected $casts = [
        'forecast_date' => 'date',
        'override_at' => 'datetime',
        'actual_cost_to_date' => 'decimal:2',
        'actual_progress' => 'decimal:2',
        'budget_cost' => 'decimal:2',
        'etc' => 'decimal:2',
        'eac_system' => 'decimal:2',
        'manual_eac' => 'decimal:2',
        'selected_eac' => 'decimal:2',
        'forecast_profit' => 'decimal:2',
        'forecast_margin' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function overrideBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'override_by');
    }
}
