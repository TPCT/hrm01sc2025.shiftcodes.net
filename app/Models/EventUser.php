<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EventUser
 *
 * @property int $id
 * @property int $event_id
 * @property int $user_id
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\Event $event
 * @method static \Illuminate\Database\Eloquent\Builder|EventUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventUser whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventUser whereUserId($value)
 * @mixin \Eloquent
 */
class EventUser extends Model
{
    use HasFactory;
    protected $table = 'event_users';

    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'user_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
