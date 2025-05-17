<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ComplaintDepartment
 *
 * @property int $id
 * @property int $complaint_id
 * @property int $department_id
 * @property-read \App\Models\Complaint $complaint
 * @property-read \App\Models\Department $department
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintDepartment whereComplaintId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintDepartment whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintDepartment whereId($value)
 * @mixin \Eloquent
 */
class ComplaintDepartment extends Model
{
    use HasFactory;

    protected $table = 'complaint_departments';

    public $timestamps = false;

    protected $fillable = [
        'complaint_id',
        'department_id'
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

}
