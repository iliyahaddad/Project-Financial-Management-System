<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectManDay extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'period',
        'planned_man_days',
        'actual_man_days',
        'man_day_variance',
        'actual_progress',
        'efficiency_ratio',
        'status',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'period' => 'date',
        'planned_man_days' => 'decimal:2',
        'actual_man_days' => 'decimal:2',
        'man_day_variance' => 'decimal:2',
        'actual_progress' => 'decimal:2',
        'efficiency_ratio' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
