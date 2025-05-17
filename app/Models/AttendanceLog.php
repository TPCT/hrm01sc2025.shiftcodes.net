<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\AttendanceLog
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $employee_id
 * @property string|null $attendance_type
 * @property string|null $identifier
 * @property-read \App\Models\User $user
 * @method static Builder|AttendanceLog newModelQuery()
 * @method static Builder|AttendanceLog newQuery()
 * @method static Builder|AttendanceLog query()
 * @method static Builder|AttendanceLog whereAttendanceType($value)
 * @method static Builder|AttendanceLog whereCreatedAt($value)
 * @method static Builder|AttendanceLog whereEmployeeId($value)
 * @method static Builder|AttendanceLog whereId($value)
 * @method static Builder|AttendanceLog whereIdentifier($value)
 * @method static Builder|AttendanceLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AttendanceLog extends Model
{
    use HasFactory;

    protected $table = 'attendance_logs';
    public $timestamps = true;

    protected $fillable = [
        'employee_id', 'attendance_type', 'identifier','created_at','updated_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('branch', function (Builder $builder) {

            $user = Auth::user();
            if (isset($user->branch_id) && (isset($user->id) && $user->id != 1)) {
                $branchId = $user->branch_id;
                $builder->whereHas('user', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                });
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
