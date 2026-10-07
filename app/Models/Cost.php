<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Cost extends ProjectCost { use HasFactory; protected $table = 'project_costs'; }