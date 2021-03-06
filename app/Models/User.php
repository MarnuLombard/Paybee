<?php

namespace PayBee\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * @property int                       $id
 * @property string                    $name
 * @property string                    $email
 * @property Carbon                    $email_verified_at
 * @property string                    $password
 * @property int                       $sender_id
 * @property string                    $default_currency
 * @property string                    $remember_token
 * @property Carbon                    $created_at
 * @property Carbon                    $updated_at
 * @property Carbon                    $deleted_at
 * @property-read Collection|Message[] $messages
 * @property-read Token                $token
 */
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'id' => 'int',
        'email_verified_at' => 'datetime',
        'sender_id' => 'int',
    ];

    public static function findByToken(string $token): ?User
    {
        /** @var Token $token */
        $token = Token::where('token', $token)->first();

        if (!$token) {
            return null;
        }

        return $token->user;
    }

    /**
     * The structure of the db allows for a one-to-many,
     * But the app requires us to use it as a one-to-one
     * A `hasOne` relationship will call `first()` on the Eloquent query
     */
    public function token(): HasOne
    {
        return $this->hasOne(Token::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
