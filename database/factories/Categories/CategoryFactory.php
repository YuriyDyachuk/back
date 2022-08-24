<?php
declare(strict_types=1);

namespace Database\Factories\Categories;

use App\Models\Categories\Category;
use App\Models\Categories\SuperCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

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
            'super_category_id' => SuperCategory::inRandomOrder()
                ->first(),
        ];
    }
}
