<?php
declare(strict_types=1);

namespace App\Models\Documents;

use App\Models\Categories\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static orderBy(string $sortedBy, string $sortedDir)
 * @method static findOrFail($id)
 * @method static pluck(string $string, string $string1)
 */
class Document extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const FILTER_NAME = 'Документ';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'url',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }
}
