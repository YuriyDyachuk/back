<?php
declare(strict_types=1);

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static pluck(string $string, string $string1)
 * @method static orderBy(string $sortedBy, string $sortedDir)
 * @method static findOrFail($id)
 * @method static where(string $string, $null)
 */
class Section extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const FILTER_NAME = 'Секция';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'document_id',
    ];

    public function document() : BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function articles() : HasMany
    {
        return $this->hasMany(Article::class);
    }
}
