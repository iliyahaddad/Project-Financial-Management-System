<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CostCategory extends Model
{
    protected $fillable = ['name', 'display_name', 'description', 'is_active'];

    public function costs(): HasMany
    {
        return $this->hasMany(ProjectCost::class);
    }
}
