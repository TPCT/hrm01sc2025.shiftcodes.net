<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\OfficeTime
 *
 * @property int $id
 * @property-read string $opening_time
 * @property-read string $closing_time
 * @property string $shift
 * @property string $category
 * @property int|null $holiday_count
 * @property string|null $description
 * @property int $company_id
 * @property int $is_active
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_early_check_in
 * @property int|null $checkin_before in minutes
 * @property int $is_early_check_out
 * @property int|null $checkout_before in minutes
 * @property int $is_late_check_in
 * @property int|null $checkin_after in minutes
 * @property int $is_late_check_out
 * @property int|null $checkout_after in minutes
 * @property string|null $shift_type
 * @property int|null $branch_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendance
 * @property-read int|null $attendance_count
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|OfficeTime newModelQuery()
 * @method static Builder|OfficeTime newQuery()
 * @method static Builder|OfficeTime query()
 * @method static Builder|OfficeTime whereBranchId($value)
 * @method static Builder|OfficeTime whereCategory($value)
 * @method static Builder|OfficeTime whereCheckinAfter($value)
 * @method static Builder|OfficeTime whereCheckinBefore($value)
 * @method static Builder|OfficeTime whereCheckoutAfter($value)
 * @method static Builder|OfficeTime whereCheckoutBefore($value)
 * @method static Builder|OfficeTime whereClosingTime($value)
 * @method static Builder|OfficeTime whereCompanyId($value)
 * @method static Builder|OfficeTime whereCreatedAt($value)
 * @method static Builder|OfficeTime whereCreatedBy($value)
 * @method static Builder|OfficeTime whereDescription($value)
 * @method static Builder|OfficeTime whereHolidayCount($value)
 * @method static Builder|OfficeTime whereId($value)
 * @method static Builder|OfficeTime whereIsActive($value)
 * @method static Builder|OfficeTime whereIsEarlyCheckIn($value)
 * @method static Builder|OfficeTime whereIsEarlyCheckOut($value)
 * @method static Builder|OfficeTime whereIsLateCheckIn($value)
 * @method static Builder|OfficeTime whereIsLateCheckOut($value)
 * @method static Builder|OfficeTime whereOpeningTime($value)
 * @method static Builder|OfficeTime whereShift($value)
 * @method static Builder|OfficeTime whereShiftType($value)
 * @method static Builder|OfficeTime whereUpdatedAt($value)
 * @method static Builder|OfficeTime whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class OfficeTime extends Model
{
    use HasFactory;

    protected $table = 'office_times';

    const CATEGORY = ['full_timer', 'part_timer'];

    const RECORD_PER_PAGE = 10;

    protected $fillable = [
        'company_id',
        'opening_time',
        'closing_time',
        'shift',
        'category',
        'holiday_count',
        'description',
        'is_active',
        'created_by',
        'updated_by',
        'is_early_check_in',
        'checkin_before',
        'is_early_check_out',
        'checkout_before',
        'is_late_check_in',
        'checkin_after',
        'is_late_check_out',
        'checkout_after',
        'shift_type',
        'branch_id'
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

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereNotNull('branch_id')
                    ->whereHas('branch', function ($query) use ($branchId) {
                        $query->where('id', $branchId);
                    });

            });
        }
    }

    /**
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * @return Attribute
     */
    protected function closingTime(): Attribute
    {
        return Attribute::make(
            get: fn($value) => date("g:i A", strtotime($value)),
        );
    }

    /**
     * @return Attribute
     */
    protected function openingTime(): Attribute
    {
        return Attribute::make(
            get: fn($value) => date("g:i A", strtotime($value)),
        );
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class, 'office_time_id', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

}
