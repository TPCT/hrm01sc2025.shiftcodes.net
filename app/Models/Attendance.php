<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * App\Models\Attendance
 *
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property string $attendance_date
 * @property string|null $check_in_at
 * @property string|null $check_out_at
 * @property float|null $check_in_latitude
 * @property float|null $check_out_latitude
 * @property float|null $check_in_longitude
 * @property float|null $check_out_longitude
 * @property string|null $note
 * @property string|null $edit_remark
 * @property int $attendance_status
 * @property int $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $check_in_type
 * @property string $check_out_type
 * @property float|null $worked_hour in minutes
 * @property float|null $overtime in minutes
 * @property float|null $undertime in minutes
 * @property string|null $check_in_note
 * @property string|null $check_out_note
 * @property string|null $night_checkin
 * @property string|null $night_checkout
 * @property int|null $office_time_id
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\OfficeTime|null $officeTime
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Attendance newModelQuery()
 * @method static Builder|Attendance newQuery()
 * @method static Builder|Attendance query()
 * @method static Builder|Attendance whereAttendanceDate($value)
 * @method static Builder|Attendance whereAttendanceStatus($value)
 * @method static Builder|Attendance whereCheckInAt($value)
 * @method static Builder|Attendance whereCheckInLatitude($value)
 * @method static Builder|Attendance whereCheckInLongitude($value)
 * @method static Builder|Attendance whereCheckInNote($value)
 * @method static Builder|Attendance whereCheckInType($value)
 * @method static Builder|Attendance whereCheckOutAt($value)
 * @method static Builder|Attendance whereCheckOutLatitude($value)
 * @method static Builder|Attendance whereCheckOutLongitude($value)
 * @method static Builder|Attendance whereCheckOutNote($value)
 * @method static Builder|Attendance whereCheckOutType($value)
 * @method static Builder|Attendance whereCompanyId($value)
 * @method static Builder|Attendance whereCreatedAt($value)
 * @method static Builder|Attendance whereCreatedBy($value)
 * @method static Builder|Attendance whereEditRemark($value)
 * @method static Builder|Attendance whereId($value)
 * @method static Builder|Attendance whereNightCheckin($value)
 * @method static Builder|Attendance whereNightCheckout($value)
 * @method static Builder|Attendance whereNote($value)
 * @method static Builder|Attendance whereOfficeTimeId($value)
 * @method static Builder|Attendance whereOvertime($value)
 * @method static Builder|Attendance whereUndertime($value)
 * @method static Builder|Attendance whereUpdatedAt($value)
 * @method static Builder|Attendance whereUpdatedBy($value)
 * @method static Builder|Attendance whereUserId($value)
 * @method static Builder|Attendance whereWorkedHour($value)
 * @mixin \Eloquent
 */
class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'user_id',
        'company_id',
        'attendance_date',
        'check_in_at',
        'check_out_at',
        'check_in_latitude',
        'check_out_latitude',
        'check_in_longitude',
        'check_out_longitude',
        'note',
        'edit_remark',
        'attendance_status',
        'created_by',
        'updated_by',
        'check_in_type',
        'check_out_type',
        'worked_hour',
        'overtime',
        'undertime',
        'check_in_note',
        'check_out_note',
        'night_checkin',
        'night_checkout',
        'office_time_id'
    ];

    const RECORDS_PER_PAGE = 20;

    const ATTENDANCE_APPROVED = 1;
    const ATTENDANCE_REJECTED = 0;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
        });

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $user = Auth::user();

            static::addGlobalScope('branch', function (Builder $builder) use($user){
                $branchId = $user->branch_id;
                $builder->whereHas('employee', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                });

            });
        }
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function officeTime()
    {
        return $this->belongsTo(OfficeTime::class, 'office_time_id', 'id');
    }


}
