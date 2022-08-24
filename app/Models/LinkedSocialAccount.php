<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class LinkedSocialAccount
 * @package App\Models
 * @method static where(array $array)
 */
class LinkedSocialAccount extends Model
{
    use HasFactory;

    public const PROVIDER_NAME = 'provider_name';
    public const PROVIDER_ID = 'provider_id';
    public const TABLE_NAME = 'linked_social_accounts';

    protected $fillable = [
        self::PROVIDER_NAME,
        self::PROVIDER_ID,
    ];

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatus() {
        return $this->status;
    }
}
