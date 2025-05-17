<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\AdvanceSalary
 *
 * @property int $id
 * @property int $employee_id
 * @property float $requested_amount
 * @property float|null $released_amount
 * @property string $advance_requested_date
 * @property string|null $amount_granted_date
 * @property string $description
 * @property int $is_settled
 * @property string $status
 * @property string|null $remark
 * @property int|null $verified_by
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdvanceSalaryAttachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $requestedBy
 * @property-read \App\Models\User|null $verifiedBy
 * @method static Builder|AdvanceSalary newModelQuery()
 * @method static Builder|AdvanceSalary newQuery()
 * @method static Builder|AdvanceSalary query()
 * @method static Builder|AdvanceSalary whereAdvanceRequestedDate($value)
 * @method static Builder|AdvanceSalary whereAmountGrantedDate($value)
 * @method static Builder|AdvanceSalary whereCreatedAt($value)
 * @method static Builder|AdvanceSalary whereCreatedBy($value)
 * @method static Builder|AdvanceSalary whereDescription($value)
 * @method static Builder|AdvanceSalary whereEmployeeId($value)
 * @method static Builder|AdvanceSalary whereId($value)
 * @method static Builder|AdvanceSalary whereIsSettled($value)
 * @method static Builder|AdvanceSalary whereReleasedAmount($value)
 * @method static Builder|AdvanceSalary whereRemark($value)
 * @method static Builder|AdvanceSalary whereRequestedAmount($value)
 * @method static Builder|AdvanceSalary whereStatus($value)
 * @method static Builder|AdvanceSalary whereUpdatedAt($value)
 * @method static Builder|AdvanceSalary whereVerifiedBy($value)
 * @mixin \Eloquent
 */
class AdvanceSalary extends Model
{
    use HasFactory;

    protected $table = 'advance_salaries';

    protected $fillable = [
        'employee_id',
        'requested_amount',
        'released_amount',
        'advance_requested_date',
        'amount_granted_date',
        'description',
        'is_settled',
        'status',
        'remark',
        'verified_by',
        'created_by',
    ];

    const RECORDS_PER_PAGE = 20;

    const STATUS = [
        'pending',
        'processing',
        'approved',
        'rejected',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->verified_by  = Auth::user()->id;
        });

        static::deleting(function ($advanceSalaryDetail) {
            $advanceSalaryDetail->attachments()->delete();
        });

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereHas('requestedBy', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                });

            });
        }
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by', 'id');
    }

    public function attachments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AdvanceSalaryAttachment::class, 'advance_salary_id', 'id');
    }
}

?>

