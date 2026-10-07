<?php
namespace Database\Factories;
use App\Models\Forecast;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
class ForecastFactory extends Factory {
 protected $model=Forecast::class;
 public function definition(): array { $project=Project::inRandomOrder()->first() ?? Project::factory()->create(); return ['project_id'=>$project->id,'forecast_date'=>now()->toDateString(),'model_type'=>'manual','eac'=>0,'etc'=>0,'forecast_profit'=>0,'forecast_margin'=>0]; }
}