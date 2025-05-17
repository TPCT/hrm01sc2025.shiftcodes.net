<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ComplaintResponse
 *
 * @property int $id
 * @property int $complaint_id
 * @property int $employee_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Complaint $complaint
 * @property-read \App\Models\User $employee
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintResponse whereComplaintId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintResponse whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintResponse whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComplaintResponse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ComplaintResponse extends Model
{
    use HasFactory;
    protected $table = 'complaint_responses';

    protected $fillable = [
        'complaint_id',
        'employee_id',
        'message'
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
