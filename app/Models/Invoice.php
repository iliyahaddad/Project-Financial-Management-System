<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'contract_id',
        'invoice_number',
        'period',
        'issue_date',
        'due_date',
        'invoice_amount',
        'approved_amount',
        'approval_date',
        'approved_by',
        'collected_amount',
        'collection_date',
        'notes',
        'attachment',
        'status',
    ];

    protected $casts = [
        'invoice_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'period' => 'date',
        'issue_date' => 'date',
        'due_date' => 'date',
        'approval_date' => 'date',
        'collection_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }
}
