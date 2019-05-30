<?php

namespace PayBee\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 */
class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
