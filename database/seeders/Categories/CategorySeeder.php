<?php
declare(strict_types=1);

namespace Database\Seeders\Categories;

use App\Models\Categories\Category;
use App\Models\Categories\SuperCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $quantity = 20;

        Category::factory()
            ->times($quantity)
            ->sequence(
                ...$this->generateSuperCategorySequence($quantity)
            )
            ->create();
    }

    /**
     * @param int $number
     *
     * @return array
     */
    private function generateSuperCategorySequence(int $number): array
    {
        return SuperCategory::take($number)
            ->get()
            ->map(function (SuperCategory $superCategory) {
                return [
                    $superCategory->categories()->getForeignKeyName() => $superCategory,
                ];
            })
            ->toArray();
    }
}
