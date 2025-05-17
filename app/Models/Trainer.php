<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Trainer
 *
 * @property int $id
 * @property string $trainer_type
 * @property int|null $branch_id
 * @property int|null $department_id
 * @property int|null $employee_id
 * @property string|null $name
 * @property string|null $contact_number
 * @property string|null $email
 * @property string|null $expertise
 * @property string|null $address
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\User|null $employee
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Trainer newModelQuery()
 * @method static Builder|Trainer newQuery()
 * @method static Builder|Trainer query()
 * @method static Builder|Trainer whereAddress($value)
 * @method static Builder|Trainer whereBranchId($value)
 * @method static Builder|Trainer whereContactNumber($value)
 * @method static Builder|Trainer whereCreatedAt($value)
 * @method static Builder|Trainer whereCreatedBy($value)
 * @method static Builder|Trainer whereDepartmentId($value)
 * @method static Builder|Trainer whereEmail($value)
 * @method static Builder|Trainer whereEmployeeId($value)
 * @method static Builder|Trainer whereExpertise($value)
 * @method static Builder|Trainer whereId($value)
 * @method static Builder|Trainer whereName($value)
 * @method static Builder|Trainer whereStatus($value)
 * @method static Builder|Trainer whereTrainerType($value)
 * @method static Builder|Trainer whereUpdatedAt($value)
 * @method static Builder|Trainer whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Trainer extends Model
{
    use HasFactory;
    protected $table = 'trainers';
    protected $fillable = [
        'trainer_type', 'branch_id', 'department_id', 'employee_id', 'name', 'contact_number', 'email', 'expertise', 'address', 'created_by', 'updated_by','status'
    ];


    const RECORDS_PER_PAGE = 20;

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('trainer', function (Builder $builder) {
            $builder->when(Auth::check() && Auth::user()->id != 1, function ($query) {
                $userBranchId = Auth::user()->branch_id ?? null;
                $query->where(function ($subquery) use ($userBranchId) {
                    $subquery->where('trainer_type', 'internal')
                        ->where(function ($branchQuery) use ($userBranchId) {
                            $branchQuery->where('branch_id', $userBranchId)
                                ->orWhereNull('branch_id');
                        })
                        ->orWhere(function ($externalQuery) use ($userBranchId) {
                            $externalQuery->where('trainer_type', 'external')
                                ->whereHas('createdBy', function ($createdByQuery) use ($userBranchId) {
                                    $createdByQuery->where('branch_id', $userBranchId);
                                });
                        });
                });
            });
        });
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class,'employee_id','id');
    }
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
