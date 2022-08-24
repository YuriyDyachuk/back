<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subscription
 * @package App\Models
 * @method static findOrFail($id)
 * @method static pluck(string $string, string $string1)
 * @method static orderBy(string $sortedBy, string $sortedDir)
 * @method static where(string $string, $subscription_type)
 */
class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    public const TABLE_NAME = 'subscriptions';
    public const FILTER_NAME = 'Подписка';

    /**
     * @return BelongsToMany
     */
    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
