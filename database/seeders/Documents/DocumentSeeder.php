<?php
declare(strict_types=1);

namespace Database\Seeders\Documents;

use App\Models\Categories\Category;
use App\Models\Documents\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $quantity = 40;

        Document::factory()
            ->times($quantity)
            ->sequence(
                ...$this->generateCategorySequence($quantity)
            )
            ->create();
    }

    /**
     * @param int $number
     *
     * @return array
     */
    private function generateCategorySequence(int $number): array
    {
        return Category::take($number)
            ->get()
            ->map(function (Category $category) {
                return [
                    $category->documents()->getForeignKeyName() => $category,
                ];
            })
            ->toArray();
    }
}
