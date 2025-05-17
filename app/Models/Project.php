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
 * App\Models\Project
 *
 * @property int $id
 * @property string $name
 * @property int|null $client_id
 * @property string $start_date
 * @property string $deadline
 * @property float $cost
 * @property string|null $estimated_hours
 * @property string $status
 * @property string $priority
 * @property string $description
 * @property string $cover_pic
 * @property int $is_active
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AssignedMember> $assignedMembers
 * @property-read int|null $assigned_members_count
 * @property-read \App\Models\Client|null $client
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $completedTask
 * @property-read int|null $completed_task_count
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $projectAttachments
 * @property-read int|null $project_attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProjectTeamLeader> $projectLeaders
 * @property-read int|null $project_leaders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Project newModelQuery()
 * @method static Builder|Project newQuery()
 * @method static Builder|Project query()
 * @method static Builder|Project whereClientId($value)
 * @method static Builder|Project whereCost($value)
 * @method static Builder|Project whereCoverPic($value)
 * @method static Builder|Project whereCreatedAt($value)
 * @method static Builder|Project whereCreatedBy($value)
 * @method static Builder|Project whereDeadline($value)
 * @method static Builder|Project whereDescription($value)
 * @method static Builder|Project whereEstimatedHours($value)
 * @method static Builder|Project whereId($value)
 * @method static Builder|Project whereIsActive($value)
 * @method static Builder|Project whereName($value)
 * @method static Builder|Project wherePriority($value)
 * @method static Builder|Project whereSlug($value)
 * @method static Builder|Project whereStartDate($value)
 * @method static Builder|Project whereStatus($value)
 * @method static Builder|Project whereUpdatedAt($value)
 * @method static Builder|Project whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'client_id',
        'start_date',
        'deadline',
        'cost',
        'estimated_hours',
        'status',
        'priority',
        'description',
        'cover_pic',
        'is_active',
        'created_by',
        'updated_by',
        'slug',
    ];

    const RECORDS_PER_PAGE = 20;

    const UPLOAD_PATH = 'uploads/projects/cover/';

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

        static::deleting(function ($projectDetail) {
            $projectDetail->assignedMembers()->delete();
            $projectDetail->projectLeaders()->delete();
            $projectDetail->tasks()->delete();
            $projectDetail->projectAttachments()->delete();
        });



        if (Auth::check() && Auth::user()->id != 1) {
            static::addGlobalScope('branch', function (Builder $builder) {
                $user = Auth::user();
                $branchId = $user->branch_id;
                $builder->whereHas('createdBy', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId)
                        ->orWhere(function ($q) {
                            $q->whereNull('branch_id')->where('id', 1);
                        });
                });
            });
        }



    }

    public function assignedMembers(): MorphMany
    {
        return $this->morphMany(AssignedMember::class, 'assignable')->whereHas('user');
    }

    public function projectAttachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
//            ->where('is_active',1)
//            ->latest();

    }

    public function completedTask(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id', 'id')
            ->where('is_active',1)
            ->whereIn('status',['completed','cancelled']);
    }

    public function projectLeaders(): HasMany
    {
        return $this->hasMany(ProjectTeamLeader::class, 'project_id', 'id')->whereHas('user');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function getProjectProgressInPercentage(): int|string
    {
        $totalTaskCount = $this->tasks()->count();
        if ($totalTaskCount < 1) {
            return 0;
        }
        $totalCompletedTaskCount = $this->completedTask()->count();
        $projectProgress = ($totalCompletedTaskCount / $totalTaskCount) * 100;
        return ceil($projectProgress);
    }

    public function getOnlyEmployeeAssignedTask(): Builder|HasMany
    {
        $authCode = getAuthUserCode();
        return $this->hasMany(Task::class, 'project_id', 'id')
            ->where(function($query) use ($authCode){
                $query->whereHas('assignedMembers.user', function ($subQuery) use ($authCode) {
                    $subQuery->where('id', $authCode);
                })
                 ->orWhereHas('project.projectLeaders', function ($subQuery) use ($authCode) {
                     $subQuery->where('leader_id', $authCode);
                });
            })
            ->where('is_active', 1)
            ->latest();
    }

    public function projectRemainingDaysToComplete(): int
    {
        $now = Carbon::now();
        if($now > Carbon::parse($this->deadline)){
            return 0;
        }
        $endDate = Carbon::parse($this->deadline);
        return $now->diffInDays($endDate);
    }

}
