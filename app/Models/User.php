<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @method static orderBy(string $string)
 * @method static paginate(int $int)
 * @method static findOrFail($id)
 * @method static create(array $input)
 * @method static where(array $array)
 * @property string name
 * @property string email
 * @property string password
 * @property int type
 * @property int subscription_type
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use HasRolesAndPermissions;

    public const TABLE_NAME = 'users';
    public const SUBSCRIBED_TO = 'subscribed_to';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'photo_url',
        'type',
        'subscription_type',
        self::SUBSCRIBED_TO,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        self::SUBSCRIBED_TO => 'datetime',
        'type'              => 'integer',
        'subscription_type' => 'integer',
    ];

    /**
     * @return MorphOne
     */
    public function picture()
    {
        return $this->morphOne(Media::class, 'model')
            ->where('model_key', 'picture');
    }

    /**
     * @param $attribute
     * @return array
     */
    public function getDefaultAttributesFor($attribute)
    {
        return $attribute == 'picture'
            ? ['model_key' => $attribute]
            : [];
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_type');
    }

    /**
     * @return HasMany
     */
    public function linkedSocialAccounts()
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    public function hasGroup($role){
        if ($this->role_id === $role) {
            return true;
        }
        return false;
    }
}
