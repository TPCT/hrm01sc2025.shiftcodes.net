<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\TaskComment
 *
 * @property int $id
 * @property string $description
 * @property int $task_id
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MentionedCommentMember> $mentionedMember
 * @property-read int|null $mentioned_member_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CommentReply> $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\Task $task
 * @method static \Illuminate\Database\Eloquent\Builder|TaskComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskComment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskComment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskComment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskComment whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskComment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskComment extends Model
{
    use HasFactory;

    protected $table = 'task_comments';

    protected $fillable = [
        'task_id',
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

    public function replies(): HasMany
    {
        return $this->hasMany(CommentReply::class, 'comment_id', 'id')->oldest();
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

}
