<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\LeaveType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $leave_allocated
 * @property int $company_id
 * @property int $is_active
 * @property int $early_exit
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType whereEarlyExit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType whereLeaveAllocated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveType whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class LeaveType extends Model
{
    use HasFactory;

    protected $table = 'leave_types';

    protected $fillable = [
        'name',
        'slug',
        'leave_allocated',
        'company_id',
        'is_active',
        'early_exit',
        'created_by',
        'updated_by',
    ];

    const RECORDS_PER_PAGE = 20;

    const IS_ACTIVE = 1;


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
        });
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


}
