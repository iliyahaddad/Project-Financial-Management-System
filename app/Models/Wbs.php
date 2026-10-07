<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wbs extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'parent_id',
        'code',
        'name',
        'description',
        'budget',
        'planned_start_date',
        'planned_end_date',
        'actual_start_date',
        'actual_end_date',
        'weight',
        'planned_progress',
        'actual_progress',
        'responsible_person_id',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'weight' => 'decimal:2',
        'planned_progress' => 'decimal:2',
        'actual_progress' => 'decimal:2',
        'planned_start_date' => 'date',
        'planned_end_date' => 'date',
        'actual_start_date' => 'date',
        'actual_end_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Wbs::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Wbs::class, 'parent_id');
    }

    public function responsiblePerson(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_person_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(ProjectProgress::class);
    }
}
