<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'project_code',
        'project_name',
        'client_id',
        'description',
        'project_manager_id',
        'start_date',
        'end_date',
        'status',
        'priority',
        'progress_method',
        'currency',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function wbs(): HasMany
    {
        return $this->hasMany(Wbs::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(ProjectProgress::class);
    }

    public function latestProgress(): HasOne
    {
        return $this->hasOne(ProjectProgress::class)->latestOfMany('period');
    }

    public function manDays(): HasMany
    {
        return $this->hasMany(ProjectManDay::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(ProjectBudget::class);
    }

    public function costs(): HasMany
    {
        return $this->hasMany(ProjectCost::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }

    public function forecasts(): HasMany
    {
        return $this->hasMany(Forecast::class);
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(Alert::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}
