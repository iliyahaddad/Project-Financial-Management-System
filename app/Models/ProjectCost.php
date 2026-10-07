<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectCost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'cost_category_id',
        'date',
        'description',
        'budget_amount',
        'actual_amount',
        'cost_variance',
        'cost_variance_percent',
        'cost_center',
        'employee_id',
        'document_number',
        'attachment',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'budget_amount' => 'decimal:2',
        'actual_amount' => 'decimal:2',
        'cost_variance' => 'decimal:2',
        'cost_variance_percent' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CostCategory::class, 'cost_category_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
