<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Training
 *
 * @property int $id
 * @property int $training_type_id
 * @property int $branch_id
 * @property float|null $cost
 * @property string $start_date
 * @property string $start_time
 * @property string|null $end_date
 * @property string $end_time
 * @property string|null $certificate
 * @property string|null $description
 * @property string $status
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $venue
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeTraining> $employeeTraining
 * @property-read int|null $employee_training_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TrainingDepartment> $trainingDepartment
 * @property-read int|null $training_department_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TrainingInstructor> $trainingInstructor
 * @property-read int|null $training_instructor_count
 * @property-read \App\Models\TrainingType $trainingType
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Training newModelQuery()
 * @method static Builder|Training newQuery()
 * @method static Builder|Training query()
 * @method static Builder|Training whereBranchId($value)
 * @method static Builder|Training whereCertificate($value)
 * @method static Builder|Training whereCost($value)
 * @method static Builder|Training whereCreatedAt($value)
 * @method static Builder|Training whereCreatedBy($value)
 * @method static Builder|Training whereDescription($value)
 * @method static Builder|Training whereEndDate($value)
 * @method static Builder|Training whereEndTime($value)
 * @method static Builder|Training whereId($value)
 * @method static Builder|Training whereStartDate($value)
 * @method static Builder|Training whereStartTime($value)
 * @method static Builder|Training whereStatus($value)
 * @method static Builder|Training whereTrainingTypeId($value)
 * @method static Builder|Training whereUpdatedAt($value)
 * @method static Builder|Training whereUpdatedBy($value)
 * @method static Builder|Training whereVenue($value)
 * @mixin \Eloquent
 */
class Training extends Model
{
    use HasFactory;
    protected $table = 'trainings';
    protected $fillable = [
        'training_type_id', 'branch_id', 'cost', 'start_date', 'start_time',
        'end_date', 'end_time', 'certificate', 'description', 'status', 'created_by', 'updated_by','venue'
    ];


    const RECORDS_PER_PAGE = 20;
    const UPLOAD_PATH = 'uploads/training/';


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

    public function trainingType(): BelongsTo
    {
        return $this->belongsTo(TrainingType::class,'training_type_id','id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function employeeTraining()
    {
        return $this->hasMany(EmployeeTraining::class,'training_id','id');
    }
    public function trainingDepartment()
    {
        return $this->hasMany(TrainingDepartment::class,'training_id','id');
    }
    public function trainingInstructor()
    {
        return $this->hasMany(TrainingInstructor::class,'training_id','id');
    }


}
