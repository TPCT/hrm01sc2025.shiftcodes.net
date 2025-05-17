<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property int $project_id
 * @property string $name
 * @property string $priority
 * @property string $status
 * @property string $start_date
 * @property string $end_date
 * @property string $description
 * @property int $is_active
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AssignedMember> $assignedMembers
 * @property-read int|null $assigned_members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaskChecklist> $completedTaskChecklist
 * @property-read int|null $completed_task_checklist_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Project $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $taskAttachments
 * @property-read int|null $task_attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaskChecklist> $taskChecklists
 * @property-read int|null $task_checklists_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TaskComment> $taskComments
 * @property-read int|null $task_comments_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Task newModelQuery()
 * @method static Builder|Task newQuery()
 * @method static Builder|Task query()
 * @method static Builder|Task whereCreatedAt($value)
 * @method static Builder|Task whereCreatedBy($value)
 * @method static Builder|Task whereDescription($value)
 * @method static Builder|Task whereEndDate($value)
 * @method static Builder|Task whereId($value)
 * @method static Builder|Task whereIsActive($value)
 * @method static Builder|Task whereName($value)
 * @method static Builder|Task wherePriority($value)
 * @method static Builder|Task whereProjectId($value)
 * @method static Builder|Task whereStartDate($value)
 * @method static Builder|Task whereStatus($value)
 * @method static Builder|Task whereUpdatedAt($value)
 * @method static Builder|Task whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'project_id',
        'name',
        'priority',
        'status',
        'start_date',
        'end_date',
        'description',
        'is_active',
        'created_by',
        'updated_by'
    ];

    const RECORDS_PER_PAGE = 20;

    const UPLOAD_PATH = 'uploads/tasks/';

    const STATUS = [
        'in_progress',
        'not_started',
        'cancelled',
        'completed'
    ];

    const PRIORITY = [
        'low',
        'medium',
        'high',
        'urgent'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
            $model->updated_by = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
        });

        static::deleting(function ($taskDetail) {
            $taskDetail->assignedMembers()->delete();
            $taskDetail->taskAttachments()->delete();
        });

        static::addGlobalScope('branch', function (Builder $builder) {
            $user = Auth::user();
            if (isset($user->branch_id) && (isset($user->id) && $user->id != 1)) {
                $branchId = $user->branch_id;
                $builder->whereHas('createdBy', function ($query) use ($branchId) {
                    $query->where(function($q) use ($branchId) {
                        $q->whereNull('branch_id')
                            ->where('id', 1)
                            ->orWhere('branch_id', $branchId);
                    });
                });
            }
        });
    }

    public function assignedMembers(): MorphMany
    {
        return $this->morphMany(AssignedMember::class, 'assignable')->whereHas('user');
    }

    public function taskAttachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id')->latest();
    }

    public function taskChecklists(): HasMany
    {
        return $this->hasMany(TaskChecklist::class, 'task_id', 'id');
    }

    public function taskComments(): HasMany
    {
        return $this->hasMany(TaskComment::class, 'task_id', 'id')->whereHas('createdBy')->oldest();
    }

    public function completedTaskChecklist(): HasMany
    {
        return $this->hasMany(TaskChecklist::class, 'task_id', 'id')
            ->where('is_completed',1);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function getTaskProgressInPercentage(): float|int
    {
        $totalChecklistCount  = $this->taskChecklists()->count();

        if($this->status == 'completed' && $totalChecklistCount == 0){
            return 100;
        }
        if($totalChecklistCount < 1){
            return 0;
        }

        $totalCompletedChecklistCount  = $this->completedTaskChecklist()->count();
        $taskProgress = ($totalCompletedChecklistCount / $totalChecklistCount) * 100;
        return ceil($taskProgress);
    }

    public function taskAssignedChecklists(): HasMany
    {
        $authCode = getAuthUserCode();
        return $this->hasMany(TaskChecklist::class, 'task_id', 'id')
            ->where(function($query) use ($authCode){
                $query->whereHas('taskAssigned', function ($subQuery) use ($authCode) {
                    $subQuery->where('assigned_to', $authCode);
                })->orWhereHas('task.project.projectLeaders', function ($subQuery) use ($authCode){
                    $subQuery->where('leader_id', $authCode);
                });
            });
    }

    public function taskRemainingDaysToComplete(): int
    {
        $now = Carbon::now();
        if($now > Carbon::parse($this->end_date)){
            return 0;
        }
        $date = Carbon::parse($this->end_date);
        return $date->diffInDays($now);
    }

}
