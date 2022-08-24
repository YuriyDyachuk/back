<?php
declare(strict_types=1);

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

/**
 * @method static pluck(string $string, string $string1)
 * @method static orderBy(string $sortedBy, string $sortedDir)
 * @method static findOrFail($id)
 */
class SuperCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const FILTER_NAME = 'СуперКатегория';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'image_id',
    ];

    /**
     * @return HasMany
     */
    public function categories() : HasMany
    {
        return $this->hasMany(Category::class);
    }
}
