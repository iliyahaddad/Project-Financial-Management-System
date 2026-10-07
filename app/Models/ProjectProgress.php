<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectProgress extends Model
{
    use SoftDeletes;

    protected $table = 'project_progress';

    protected $fillable = [
        'project_id',
        'wbs_id',
        'activity_id',
        'period',
        'planned_progress',
        'actual_progress',
        'progress_variance',
        'management_note',
        'recorded_by',
    ];

    protected $casts = [
        'period' => 'date',
        'planned_progress' => 'decimal:2',
        'actual_progress' => 'decimal:2',
        'progress_variance' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function wbs(): BelongsTo
    {
        return $this->belongsTo(Wbs::class);
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
