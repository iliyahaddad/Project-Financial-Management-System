<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'contract_number',
        'contract_type',
        'contract_date',
        'start_date',
        'end_date',
        'contract_amount',
        'amendment_amount',
        'adjustment_amount',
        'final_contract_amount',
        'contract_man_days',
        'project_manager_id',
        'status',
        'description',
    ];

    protected $casts = [
        'contract_amount' => 'decimal:2',
        'amendment_amount' => 'decimal:2',
        'adjustment_amount' => 'decimal:2',
        'final_contract_amount' => 'decimal:2',
        'contract_man_days' => 'integer',
        'contract_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }

    public function amendments(): HasMany
    {
        return $this->hasMany(ContractAmendment::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
