<?php
/**
 * Created by PhpStorm.
 * User: Sanad
 * Date: 11/17/2020
 * Time: 6:16 PM
 */

namespace Database\Factories;


use App\Models\JobPost;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPostFactory extends Factory
{

    protected $model = JobPost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'                   => 1,
            'title'                     => $this->faker->title(),
            'required_experience_level' => $this->faker->catchPhrase,
            'job_requirements'          => $this->faker->text(),
            'start_date'                => Carbon::now(),
            'end_date'                  => Carbon::now()->addWeek(),
        ];
    }
}