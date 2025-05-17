<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\MentionedCommentMember
 *
 * @property int $id
 * @property int $member_id
 * @property string $mentionable_type
 * @property int $mentionable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $mentionable
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|MentionedCommentMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentionedCommentMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MentionedCommentMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|MentionedCommentMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentionedCommentMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentionedCommentMember whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentionedCommentMember whereMentionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentionedCommentMember whereMentionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MentionedCommentMember whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MentionedCommentMember extends Model
{
    use HasFactory;

    protected $table = 'mentioned_comment_members';

    protected $fillable = [
        'member_id',
        'mentionable_id',
        'mentionable_type',
    ];

    public function mentionable(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'mentionable_type', 'mentionable_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }
}
