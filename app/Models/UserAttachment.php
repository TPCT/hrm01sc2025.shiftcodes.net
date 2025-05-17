<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserAttachment
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string|null $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\UserAttachmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttachment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttachment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttachment whereUserId($value)
 * @mixin \Eloquent
 */
class UserAttachment extends Model
{
    use HasFactory;

    protected $table = 'user_attachments';

    protected $fillable = [
        'notification_id',
        'user_id',
        'type',
        'path',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
