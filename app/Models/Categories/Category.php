<?php
declare(strict_types=1);

namespace App\Models\Categories;

use App\Models\Documents\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static orderBy(string $sortedBy, string $sortedDir)
 * @method static findOrFail($id)
 * @method static select(string $string)
 * @method static where(string $string, $null)
 */
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const FILTER_NAME = 'Категория';
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'super_category_id',
    ];

    public function superCategory(): BelongsTo
    {
        return $this->belongsTo(SuperCategory::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
