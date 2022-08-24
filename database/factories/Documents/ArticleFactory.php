<?php
declare(strict_types=1);

namespace Database\Factories\Documents;

use App\Models\Documents\Article;
use App\Models\Documents\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

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
            'text' => $this->faker->realText(500),
            'section_id' => Section::inRandomOrder()
                ->first(),
        ];
    }
}
