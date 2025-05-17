<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TaskChecklist
 *
 * @property int $id
 * @property string $name
 * @property int $task_id
 * @property int $assigned_to
 * @property int $is_completed
 * @property-read \App\Models\Task $task
 * @property-read \App\Models\User $taskAssigned
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChecklist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChecklist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChecklist query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChecklist whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChecklist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChecklist whereIsCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChecklist whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskChecklist whereTaskId($value)
 * @mixin \Eloquent
 */
class TaskChecklist extends Model
{
    use HasFactory;

    protected $table = 'task_checklists';

    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'name',
        'is_completed',
        'assigned_to'
     ];


    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function taskAssigned(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }



}
