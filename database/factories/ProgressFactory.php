<?php
namespace Database\Factories;
use App\Models\Progress;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
class ProgressFactory extends Factory {
 protected $model=Progress::class;
 public function definition(): array { $project=Project::inRandomOrder()->first() ?? Project::factory()->create(); return ['project_id'=>$project->id,'period'=>now()->toDateString(),'planned_progress'=>50,'actual_progress'=>40]; }
}