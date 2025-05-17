<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Warning
 *
 * @property int $id
 * @property int $branch_id
 * @property string $subject
 * @property string $warning_date
 * @property string|null $message
 * @property string $status
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WarningDepartment> $warningDepartment
 * @property-read int|null $warning_department_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WarningEmployee> $warningEmployee
 * @property-read int|null $warning_employee_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WarningResponse> $warningReply
 * @property-read int|null $warning_reply_count
 * @method static Builder|Warning newModelQuery()
 * @method static Builder|Warning newQuery()
 * @method static Builder|Warning query()
 * @method static Builder|Warning whereBranchId($value)
 * @method static Builder|Warning whereCreatedAt($value)
 * @method static Builder|Warning whereCreatedBy($value)
 * @method static Builder|Warning whereId($value)
 * @method static Builder|Warning whereMessage($value)
 * @method static Builder|Warning whereStatus($value)
 * @method static Builder|Warning whereSubject($value)
 * @method static Builder|Warning whereUpdatedAt($value)
 * @method static Builder|Warning whereUpdatedBy($value)
 * @method static Builder|Warning whereWarningDate($value)
 * @mixin \Eloquent
 */
class Warning extends Model
{
    use HasFactory;
    protected $table = 'warnings';
    protected $fillable = [
        'branch_id', 'subject', 'warning_date', 'message', 'status', 'created_by', 'updated_by'
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

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function warningEmployee()
    {
        return $this->hasMany(WarningEmployee::class,'warning_id','id');
    }
    public function warningDepartment()
    {
        return $this->hasMany(WarningDepartment::class,'warning_id','id');
    }
    public function warningReply()
    {
        return $this->hasMany(WarningResponse::class,'warning_id','id');
    }
}
