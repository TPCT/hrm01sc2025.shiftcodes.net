<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\LeaveRequestMaster
 *
 * @property int $id
 * @property int $no_of_days
 * @property int|null $leave_type_id
 * @property string $leave_requested_date
 * @property string $leave_from
 * @property string $leave_to
 * @property string $status
 * @property string $reasons
 * @property string|null $admin_remark
 * @property int $company_id
 * @property int $requested_by
 * @property int $early_exit
 * @property int|null $request_updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $referred_by
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $title
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeaveApprovalProcess> $approvalProcess
 * @property-read int|null $approval_process_count
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\LeaveApproval|null $leaveApproval
 * @property-read \App\Models\User|null $leaveRequestUpdatedBy
 * @property-read \App\Models\User $leaveRequestedBy
 * @property-read \App\Models\LeaveType|null $leaveType
 * @property-read \App\Models\User|null $referredBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeaveRequestApproval> $requestApproval
 * @property-read int|null $request_approval_count
 * @method static Builder|LeaveRequestMaster newModelQuery()
 * @method static Builder|LeaveRequestMaster newQuery()
 * @method static Builder|LeaveRequestMaster query()
 * @method static Builder|LeaveRequestMaster whereAdminRemark($value)
 * @method static Builder|LeaveRequestMaster whereCompanyId($value)
 * @method static Builder|LeaveRequestMaster whereCreatedAt($value)
 * @method static Builder|LeaveRequestMaster whereEarlyExit($value)
 * @method static Builder|LeaveRequestMaster whereEndTime($value)
 * @method static Builder|LeaveRequestMaster whereId($value)
 * @method static Builder|LeaveRequestMaster whereLeaveFrom($value)
 * @method static Builder|LeaveRequestMaster whereLeaveRequestedDate($value)
 * @method static Builder|LeaveRequestMaster whereLeaveTo($value)
 * @method static Builder|LeaveRequestMaster whereLeaveTypeId($value)
 * @method static Builder|LeaveRequestMaster whereNoOfDays($value)
 * @method static Builder|LeaveRequestMaster whereReasons($value)
 * @method static Builder|LeaveRequestMaster whereReferredBy($value)
 * @method static Builder|LeaveRequestMaster whereRequestUpdatedBy($value)
 * @method static Builder|LeaveRequestMaster whereRequestedBy($value)
 * @method static Builder|LeaveRequestMaster whereStartTime($value)
 * @method static Builder|LeaveRequestMaster whereStatus($value)
 * @method static Builder|LeaveRequestMaster whereTitle($value)
 * @method static Builder|LeaveRequestMaster whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LeaveRequestMaster extends Model
{
    use HasFactory;

    protected $table = 'leave_requests_master';

    protected $fillable = [

        'leave_type_id',
        'no_of_days',
        'leave_requested_date',
        'leave_from',
        'leave_to',
        'reasons',
        'status',
        'admin_remark',
        'company_id',
        'requested_by',
        'early_exit',
        'request_updated_by',
        'referred_by',
        'start_time',
        'end_time',
        'title'
    ];

    const RECORDS_PER_PAGE = 10;

    const STATUS = ['pending','approved','rejected','cancelled'];

    public static function boot()
    {
        parent::boot();

//        static::creating(function ($model) {
//            $model->requested_by = Auth::user()->id;
//        });

        static::updating(function ($model) {
            $model->request_updated_by = Auth::user()->id;
        });

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereHas('leaveRequestedBy', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                });

            });
        }

    }

    public function leaveRequestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by', 'id');
    }

    public function leaveRequestUpdatedBy()
    {
        return $this->belongsTo(User::class, 'request_updated_by', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id');
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }

    public function leaveApproval()
    {
        return $this->belongsTo(LeaveApproval::class, 'leave_type_id', 'leave_type_id');
    }

    // Relationship to LeaveApprovalProcess
    public function approvalProcess()
    {
        return $this->hasMany(LeaveApprovalProcess::class, 'leave_approval_id', 'leave_type_id');
    }
    public function requestApproval()
    {
        return $this->hasMany(LeaveRequestApproval::class, 'leave_request_id', 'id');
    }

}
