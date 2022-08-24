<?php
declare(strict_types=1);

namespace Database\Seeders\Documents;

use App\Models\Documents\Document;
use App\Models\Documents\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Document::all()->each(function (Document $document) {
            Section::factory()
                ->times(5)
                ->create([
                    $document->sections()->getForeignKeyName() => $document,
                ]);
        });
    }
}
