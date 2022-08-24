<?php
declare(strict_types=1);

namespace Database\Factories\Documents;

use App\Models\Documents\Document;
use App\Models\Documents\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

class SectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Section::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'document_id' => Document::inRandomOrder()
                ->first(),
        ];
    }
}
