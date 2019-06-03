<?php

namespace PayBee\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int       $id
 * @property int       $user_id
 * @property string    $token
 * @property Carbon    $created_at
 * @property Carbon    $updated_at
 * @property-read User $user
 */
class Token extends Model
{
    protected $guarded = ['id'];

    public static function forUser(User $user): Token
    {
        if (!$user->exists) {
            throw new \ErrorException("A user must be saved before generating a token for them");
        }

        $token = \Hash::make($user->id.$user->email);

        return self::create([
            'token' => $token,
            'user_id' => $user->id,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
