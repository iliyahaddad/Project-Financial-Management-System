<?php
namespace Database\Factories;
use App\Models\ManDay;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
class ManDayFactory extends Factory {
 protected $model=ManDay::class;
 public function definition(): array { $project=Project::inRandomOrder()->first() ?? Project::factory()->create(); return ['project_id'=>$project->id,'period'=>now()->toDateString(),'planned_man_days'=>100,'actual_man_days'=>100,'actual_progress'=>50,'efficiency_ratio'=>1]; }
}