<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'invoice_id',
        'collection_number',
        'collection_date',
        'amount',
        'payment_method',
        'reference_number',
        'bank_name',
        'received_by',
        'notes',
        'attachment',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'collection_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
