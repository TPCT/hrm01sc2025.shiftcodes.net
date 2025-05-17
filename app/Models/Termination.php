<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Termination
 *
 * @property int $id
 * @property int $employee_id
 * @property int $termination_type_id
 * @property string $notice_date
 * @property string $termination_date
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
 * @property-read \App\Models\TerminationType $terminationType
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Termination newModelQuery()
 * @method static Builder|Termination newQuery()
 * @method static Builder|Termination query()
 * @method static Builder|Termination whereAdminRemark($value)
 * @method static Builder|Termination whereCreatedAt($value)
 * @method static Builder|Termination whereCreatedBy($value)
 * @method static Builder|Termination whereDocument($value)
 * @method static Builder|Termination whereEmployeeId($value)
 * @method static Builder|Termination whereId($value)
 * @method static Builder|Termination whereNoticeDate($value)
 * @method static Builder|Termination whereReason($value)
 * @method static Builder|Termination whereStatus($value)
 * @method static Builder|Termination whereTerminationDate($value)
 * @method static Builder|Termination whereTerminationTypeId($value)
 * @method static Builder|Termination whereUpdatedAt($value)
 * @method static Builder|Termination whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Termination extends Model
{
    use HasFactory;
    protected $table = 'terminations';

    protected $fillable = [
        'employee_id','termination_type_id','notice_date','termination_date','reason','status','admin_remark','created_by','updated_by','document'
    ];

    const RECORDS_PER_PAGE = 20;
    const UPLOAD_PATH = 'uploads/termination/';

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
    public function terminationType(): BelongsTo
    {
        return $this->belongsTo(TerminationType::class, 'termination_type_id', 'id');
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
