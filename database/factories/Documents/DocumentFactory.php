<?php
declare(strict_types=1);

namespace Database\Factories\Documents;

use App\Models\Categories\Category;
use App\Models\Documents\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Document::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => implode(' ', $this->faker->words(
                $this->faker->numberBetween(1, 5)
            )),
            'description' => $this->faker->sentence,
            'url' => $this->faker->url,
            'category_id' => Category::inRandomOrder()
                ->first(),
        ];
    }
}
