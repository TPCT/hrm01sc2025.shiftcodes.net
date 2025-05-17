<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\AssignedMember
 *
 * @property int $id
 * @property int $member_id
 * @property string $assignable_type
 * @property int $assignable_id
 * @property-read Model|\Eloquent $assignable
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|AssignedMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssignedMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssignedMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssignedMember whereAssignableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignedMember whereAssignableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignedMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignedMember whereMemberId($value)
 * @mixin \Eloquent
 */
class AssignedMember extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'assigned_members';

    protected $fillable = [
        'member_id',
        'assignable_id',
        'assignable_type',
    ];

    public function assignable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'assignable_type', 'assignable_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }
}
