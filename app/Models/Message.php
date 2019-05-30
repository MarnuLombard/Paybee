<?php

namespace PayBee\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int    $id
 * @property string $conversation_uuid
 * @property int    $direction  See class constants
 * @property int    $user_id
 * @property int    $sender_id
 * @property string $sender_first_name
 * @property string $sender_last_name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read User $user
 */
class Message extends Model
{
    use SoftDeletes;

    const DIRECTION_INCOMING = 1;
    const DIRECTION_OUTGOING = 2;

    protected $guarded = ['id'];
    protected $casts = [
        'id' => 'int',
        'direction' => 'int',
        'user_id' => 'int',
        'sender_id' => 'int',
    ];

    public function user(): HasOne
    {
        return $this->belongsTo(User::class);
    }
}
