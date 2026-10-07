<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'wbs_id',
        'activity_code',
        'name',
        'description',
        'start_date',
        'end_date',
        'planned_weight',
        'planned_progress',
        'actual_progress',
        'responsible_person_id',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'planned_weight' => 'decimal:2',
        'planned_progress' => 'decimal:2',
        'actual_progress' => 'decimal:2',
    ];

    public function wbs(): BelongsTo
    {
        return $this->belongsTo(Wbs::class);
    }

    public function responsiblePerson(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_person_id');
    }
}
