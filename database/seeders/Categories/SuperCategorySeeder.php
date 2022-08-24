<?php
declare(strict_types=1);

namespace Database\Seeders\Categories;

use App\Models\Categories\SuperCategory;
use Illuminate\Database\Seeder;

class SuperCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $quantity = 10;

        SuperCategory::factory()
            ->times($quantity)
            ->sequence(
                ...$this->generateImageIdSequence($quantity, 'image_id')
            )
            ->create();
    }

    /**
     * @param int $number
     * @param string $colName
     *
     * @return array
     */
    private function generateImageIdSequence(int $number, string $colName): array
    {
        return array_map(function (int $imageId) use ($colName) {
            return [
                $colName => $imageId,
            ];
        }, range(1, $number));
    }
}
