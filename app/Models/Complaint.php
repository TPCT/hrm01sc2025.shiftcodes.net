<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Complaint
 *
 * @property int $id
 * @property int $complaint_from
 * @property int $branch_id
 * @property string $subject
 * @property string $complaint_date
 * @property string|null $message
 * @property string $status
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $image
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\User $complainFrom
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ComplaintDepartment> $complaintDepartment
 * @property-read int|null $complaint_department_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ComplaintEmployee> $complaintEmployee
 * @property-read int|null $complaint_employee_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ComplaintResponse> $complaintReply
 * @property-read int|null $complaint_reply_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Complaint newModelQuery()
 * @method static Builder|Complaint newQuery()
 * @method static Builder|Complaint query()
 * @method static Builder|Complaint whereBranchId($value)
 * @method static Builder|Complaint whereComplaintDate($value)
 * @method static Builder|Complaint whereComplaintFrom($value)
 * @method static Builder|Complaint whereCreatedAt($value)
 * @method static Builder|Complaint whereCreatedBy($value)
 * @method static Builder|Complaint whereId($value)
 * @method static Builder|Complaint whereImage($value)
 * @method static Builder|Complaint whereMessage($value)
 * @method static Builder|Complaint whereStatus($value)
 * @method static Builder|Complaint whereSubject($value)
 * @method static Builder|Complaint whereUpdatedAt($value)
 * @method static Builder|Complaint whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Complaint extends Model
{
    use HasFactory;

    protected $table = 'complaints';
    protected $fillable = [
        'complaint_from','branch_id', 'subject', 'complaint_date', 'message', 'status', 'created_by', 'updated_by','image'
    ];


    const RECORDS_PER_PAGE = 20;
    const UPLOAD_PATH = 'uploads/complaint/';

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
    public function complainFrom(): BelongsTo
    {
        return $this->belongsTo(User::class, 'complaint_from', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function complaintEmployee()
    {
        return $this->hasMany(ComplaintEmployee::class,'complaint_id','id');
    }
    public function complaintDepartment()
    {
        return $this->hasMany(ComplaintDepartment::class,'complaint_id','id');
    }
    public function complaintReply()
    {
        return $this->hasMany(ComplaintResponse::class,'complaint_id','id');
    }
}
