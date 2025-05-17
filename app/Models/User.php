<?php

namespace App\Models;

use App\Helpers\AppHelper;
use App\Helpers\AttendanceHelper;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;
use PhpParser\Builder\Function_;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $username
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $address
 * @property string|null $avatar
 * @property string|null $dob
 * @property string $gender
 * @property float|null $phone
 * @property string $status
 * @property int $is_active
 * @property int $online_status
 * @property int|null $role_id
 * @property int|null $leave_allocated
 * @property string $employment_type
 * @property string $user_type
 * @property string|null $joining_date
 * @property int $workspace_type
 * @property string|null $uuid
 * @property string|null $fcm_token
 * @property string|null $device_type
 * @property int $logout_status
 * @property string|null $remarks
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $department_id
 * @property int|null $post_id
 * @property int|null $supervisor_id
 * @property int|null $office_time_id
 * @property string|null $remember_token
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $marital_status
 * @property string|null $employee_code
 * @property-read \App\Models\EmployeeAccount|null $accountDetail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserAttachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \App\Models\AttendanceLog|null $attendanceLog
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Award> $awards
 * @property-read int|null $awards_count
 * @property-read \App\Models\Branch|null $branch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \App\Models\Company|null $company
 * @property-read User|null $createdBy
 * @property-read \App\Models\Department|null $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $employeeAttendance
 * @property-read int|null $employee_attendance_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $employeeTodayAttendance
 * @property-read int|null $employee_today_attendance_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $employeeWeeklyAttendance
 * @property-read int|null $employee_weekly_attendance_count
 * @property-read \App\Models\OfficeTime|null $officeTime
 * @property-read \App\Models\Post|null $post
 * @property-read \App\Models\Role|null $role
 * @property-read User|null $supervisor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read User|null $updatedBy
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User notAdmin()
 * @method static Builder|User onlyTrashed()
 * @method static Builder|User query()
 * @method static Builder|User whereAddress($value)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereBranchId($value)
 * @method static Builder|User whereCompanyId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCreatedBy($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereDeletedBy($value)
 * @method static Builder|User whereDepartmentId($value)
 * @method static Builder|User whereDeviceType($value)
 * @method static Builder|User whereDob($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereEmployeeCode($value)
 * @method static Builder|User whereEmploymentType($value)
 * @method static Builder|User whereFcmToken($value)
 * @method static Builder|User whereGender($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsActive($value)
 * @method static Builder|User whereJoiningDate($value)
 * @method static Builder|User whereLeaveAllocated($value)
 * @method static Builder|User whereLogoutStatus($value)
 * @method static Builder|User whereMaritalStatus($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereOfficeTimeId($value)
 * @method static Builder|User whereOnlineStatus($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User wherePostId($value)
 * @method static Builder|User whereRemarks($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRoleId($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereSupervisorId($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUpdatedBy($value)
 * @method static Builder|User whereUserType($value)
 * @method static Builder|User whereUsername($value)
 * @method static Builder|User whereUuid($value)
 * @method static Builder|User whereWorkspaceType($value)
 * @method static Builder|User withTrashed()
 * @method static Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const AVATAR_UPLOAD_PATH = 'uploads/user/avatar/';
    const ATTACHMENT_UPLOAD_PATH = 'uploads/user/attachment/';
    const RECORDS_PER_PAGE = 20;
    const GENDER = ['male', 'female', 'others'];
    const STATUS = ['pending', 'verified', 'rejected', 'suspended'];
    const EMPLOYMENT_TYPE = ['contract', 'permanent', 'temporary'];
    const USER_TYPE = ['field', 'nonField'];
    const DEVICE_TYPE = ['android', 'ios', 'web'];
    const ANDROID = 'android';
    const IOS = 'ios';
    const WEB = 'web';
    const ONLINE = 1;
    const OFFLINE = 0;
    const FIELD = 0;
    const OFFICE = 1;
    const DEMO_USERS_USERNAME = [];

    const MARITAL_STATUS = [
        'single',
        'married'
    ];



    const LOGOUT_STATUS = [
        'pending' => 1,
        'approve' => 0
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'address',
        'dob',
        'gender',
        'marital_status',
        'phone',
        'status',
        'is_active',
        'avatar',
        'leave_allocated',
        'employment_type',
        'user_type',
        'joining_date',
        'workspace_type',
        'remarks',
        'uuid',
        'fcm_token',
        'device_type',
        'logout_status',
        'company_id',
        'online_status',
        'branch_id',
        'department_id',
        'post_id',
        'role_id',
        'supervisor_id',
        'office_time_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at',
        'employee_code'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? AppHelper::findAdminUserAuthId();
        });

        static::deleting(function ($model) {
            $model->deleted_by = auth()->user()->id;
            $model->save();
        });

    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id')->select('name', 'id', 'slug');
    }

    public function officeTime(): BelongsTo
    {
        return $this->belongsTo(OfficeTime::class, 'office_time_id', 'id')->select('id', 'opening_time', 'closing_time', 'shift');
    }

    public function employeeAttendance(): HasMany
    {
        return $this->hasMany(Attendance::class, 'user_id', 'id');
    }

    public function employeeTodayAttendance(): HasMany
    {
        return $this->hasMany(Attendance::class, 'user_id', 'id')
            ->where('attendance_date', Carbon::now()->format('Y-m-d'))
            ->orderBy('attendances.created_at','desc');
    }

    public function employeeWeeklyAttendance(): HasMany
    {
        $currentDate = Carbon::now();
        $weekStartDate = AttendanceHelper::getStartOfWeekDate($currentDate);
        $weekEndDate = AttendanceHelper::getEndOfWeekDate($currentDate);
        return $this->hasMany(Attendance::class, 'user_id', 'id')
            ->where('attendance_status', 1)
            ->whereBetween('attendance_date', [$weekStartDate, $weekEndDate])
            ->orderBy('attendance_date', 'ASC');
    }

    public function accountDetail(): HasOne
    {
        return $this->hasOne(EmployeeAccount::class, 'user_id', 'id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function scopeNotAdmin($query)
    {
        return $query->whereHas('role', function ($query) {
            $query->where('slug', '!=', 'admin');
        });
    }
    public function awards(): HasMany
    {
        return $this->hasMany(Award::class, 'employee_id', 'id');
    }

    public function attendanceLog()
    {
        return $this->hasOne(AttendanceLog::class, 'employee_id','id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id', 'id');
    }

    public function attachments(){
        return $this->hasMany(UserAttachment::class, 'user_id', 'id');
    }

}
