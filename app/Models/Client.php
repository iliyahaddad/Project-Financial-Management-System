<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use SoftDeletes;

    use HasFactory;

    protected $fillable = [
        'name',
        'company_name',
        'contact_person',
        'email',
        'phone',
        'address',
        'economic_code',
        'national_id',
        'status',
        'notes',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
