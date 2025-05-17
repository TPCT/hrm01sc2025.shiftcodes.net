<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ComplaintEmployee
 *
 * @property int $id
 * @property int $complaint_id
 * @property int $employee_id
 * @property-read \App\Models\Complaint $complaint
 * @property-read \App\Models\User $employee
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintEmployee whereComplaintId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintEmployee whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintEmployee whereId($value)
 * @mixin \Eloquent
 */
class ComplaintEmployee extends Model
{
    use HasFactory;

    protected $table = 'complaint_employees';

    public $timestamps = false;

    protected $fillable = [
        'complaint_id',
        'employee_id'
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'complaint_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
