<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Transfer
 *
 * @property int $id
 * @property int $old_branch_id
 * @property int $old_department_id
 * @property int $employee_id
 * @property int $branch_id
 * @property int $department_id
 * @property string $transfer_date
 * @property string|null $description
 * @property string $status
 * @property string|null $remark
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $old_post_id
 * @property int|null $post_id
 * @property int|null $old_office_time_id
 * @property int|null $office_time_id
 * @property int|null $old_supervisor_id
 * @property int|null $supervisor_id
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Department $department
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\OfficeTime|null $officeTime
 * @property-read \App\Models\Branch $oldBranch
 * @property-read \App\Models\Department $oldDepartment
 * @property-read \App\Models\OfficeTime|null $oldOfficeTime
 * @property-read \App\Models\Post|null $oldPost
 * @property-read \App\Models\User|null $oldSupervisor
 * @property-read \App\Models\Post|null $post
 * @property-read \App\Models\User|null $supervisor
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Transfer newModelQuery()
 * @method static Builder|Transfer newQuery()
 * @method static Builder|Transfer query()
 * @method static Builder|Transfer whereBranchId($value)
 * @method static Builder|Transfer whereCreatedAt($value)
 * @method static Builder|Transfer whereCreatedBy($value)
 * @method static Builder|Transfer whereDepartmentId($value)
 * @method static Builder|Transfer whereDescription($value)
 * @method static Builder|Transfer whereEmployeeId($value)
 * @method static Builder|Transfer whereId($value)
 * @method static Builder|Transfer whereOfficeTimeId($value)
 * @method static Builder|Transfer whereOldBranchId($value)
 * @method static Builder|Transfer whereOldDepartmentId($value)
 * @method static Builder|Transfer whereOldOfficeTimeId($value)
 * @method static Builder|Transfer whereOldPostId($value)
 * @method static Builder|Transfer whereOldSupervisorId($value)
 * @method static Builder|Transfer wherePostId($value)
 * @method static Builder|Transfer whereRemark($value)
 * @method static Builder|Transfer whereStatus($value)
 * @method static Builder|Transfer whereSupervisorId($value)
 * @method static Builder|Transfer whereTransferDate($value)
 * @method static Builder|Transfer whereUpdatedAt($value)
 * @method static Builder|Transfer whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Transfer extends Model
{
    use HasFactory;

    protected $table = 'transfers';
    protected $fillable = [
        'old_branch_id', 'old_department_id','employee_id','branch_id', 'department_id', 'transfer_date', 'description', 'status', 'created_by', 'updated_by','remark','old_post_id'
        ,'post_id','old_office_time_id','office_time_id','old_supervisor_id','supervisor_id'
    ];


    const RECORDS_PER_PAGE = 20;

    public static function boot()
    {
        parent::boot();

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereHas('branch', function ($query) use ($branchId) {
                    $query->where('id', $branchId);
                });

            });
        }
    }


    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }
    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id','id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }
    public function supervisor()
    {
        return $this->belongsTo(User::class,'supervisor_id','id');
    }
    public function officeTime()
    {
        return $this->belongsTo(OfficeTime::class,'office_time_id','id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function oldBranch()
    {
        return $this->belongsTo(Branch::class,'old_branch_id','id');
    }
    public function oldDepartment()
    {
        return $this->belongsTo(Department::class,'old_department_id','id');
    }

    public function oldPost()
    {
        return $this->belongsTo(Post::class,'old_post_id','id');
    }
    public function oldSupervisor()
    {
        return $this->belongsTo(User::class,'old_supervisor_id','id');
    }
    public function oldOfficeTime()
    {
        return $this->belongsTo(OfficeTime::class,'old_office_time_id','id');
    }
}
