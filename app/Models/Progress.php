<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Progress extends ProjectProgress { use HasFactory; protected $table = 'project_progress'; }