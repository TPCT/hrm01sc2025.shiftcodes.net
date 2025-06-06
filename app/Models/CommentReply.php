<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\CommentReply
 *
 * @property int $id
 * @property string $description
 * @property int $comment_id
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TaskComment $comment
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MentionedCommentMember> $mentionedMember
 * @property-read int|null $mentioned_member_count
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CommentReply extends Model
{
    use HasFactory;

    protected $table = 'comment_replies';

    protected $fillable = [
        'comment_id',
        'description',
        'created_by',
    ];

    const RECORDS_PER_PAGE = 20;

    const UPLOAD_PATH = 'uploads/task/comments';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->created_by = Auth::user()->id;
        });

        static::deleting(function ($taskDetail) {

        });
    }

    public function mentionedMember(): MorphMany
    {
        return $this->morphMany(MentionedCommentMember::class, 'mentionable');
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(TaskComment::class, 'comment_id', 'id')->latest();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
