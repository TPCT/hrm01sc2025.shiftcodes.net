<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Resignation
 *
 * @property int $id
 * @property int $employee_id
 * @property string $resignation_date
 * @property string $last_working_day
 * @property string|null $reason
 * @property string|null $admin_remark
 * @property string|null $document
 * @property string $status
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Resignation newModelQuery()
 * @method static Builder|Resignation newQuery()
 * @method static Builder|Resignation query()
 * @method static Builder|Resignation whereAdminRemark($value)
 * @method static Builder|Resignation whereCreatedAt($value)
 * @method static Builder|Resignation whereCreatedBy($value)
 * @method static Builder|Resignation whereDocument($value)
 * @method static Builder|Resignation whereEmployeeId($value)
 * @method static Builder|Resignation whereId($value)
 * @method static Builder|Resignation whereLastWorkingDay($value)
 * @method static Builder|Resignation whereReason($value)
 * @method static Builder|Resignation whereResignationDate($value)
 * @method static Builder|Resignation whereStatus($value)
 * @method static Builder|Resignation whereUpdatedAt($value)
 * @method static Builder|Resignation whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Resignation extends Model
{
    use HasFactory;
    protected $table = 'resignations';

    protected $fillable = [
        'employee_id','resignation_date','last_working_day','reason','status','admin_remark','created_by','updated_by','document'
    ];

    const RECORDS_PER_PAGE = 20;
    const UPLOAD_PATH = 'uploads/resignation/';

    public static function boot()
    {
        parent::boot();

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereHas('employee', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                });

            });
        }
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
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
