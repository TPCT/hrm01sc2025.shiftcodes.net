<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\TimeLeave
 *
 * @property int $id
 * @property string $issue_date
 * @property string $start_time
 * @property string $end_time
 * @property string $status
 * @property string $reasons
 * @property string|null $admin_remark
 * @property int $requested_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $request_updated_by
 * @property int|null $referred_by
 * @property-read \App\Models\User|null $leaveRequestUpdatedBy
 * @property-read \App\Models\User $leaveRequestedBy
 * @property-read \App\Models\User|null $referredBy
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave query()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereAdminRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereReasons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereReferredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereRequestUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeLeave whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TimeLeave extends Model
{
    use HasFactory;
    protected $table = 'time_leaves';

    protected $fillable = ['issue_date', 'start_time', 'end_time', 'status', 'reasons', 'admin_remark', 'requested_by','request_updated_by','referred_by'];

    const RECORDS_PER_PAGE = 10;

    public function leaveRequestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by', 'id');
    }

    public function leaveRequestUpdatedBy()
    {
        return $this->belongsTo(User::class, 'request_updated_by', 'id');
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by', 'id');
    }


}
