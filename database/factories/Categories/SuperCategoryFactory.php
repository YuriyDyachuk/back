<?php
declare(strict_types=1);

namespace Database\Factories\Categories;

use App\Models\Categories\SuperCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuperCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SuperCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => implode(' ', $this->faker->words(
                $this->faker->numberBetween(1, 3)
            )),
            'description' => $this->faker->text(),
            'image_id' => 0,
        ];
    }
}
