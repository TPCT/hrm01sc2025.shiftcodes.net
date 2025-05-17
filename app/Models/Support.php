<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Support
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int|null $department_id
 * @property string $status
 * @property int $is_seen
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\Department|null $departmentQuery
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Support newModelQuery()
 * @method static Builder|Support newQuery()
 * @method static Builder|Support query()
 * @method static Builder|Support whereCreatedAt($value)
 * @method static Builder|Support whereCreatedBy($value)
 * @method static Builder|Support whereDepartmentId($value)
 * @method static Builder|Support whereDescription($value)
 * @method static Builder|Support whereId($value)
 * @method static Builder|Support whereIsSeen($value)
 * @method static Builder|Support whereStatus($value)
 * @method static Builder|Support whereTitle($value)
 * @method static Builder|Support whereUpdatedAt($value)
 * @method static Builder|Support whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Support extends Model
{
    use HasFactory;

    protected $table = 'supports';

    protected $fillable = [
        'title',
        'description',
        'is_seen',
        'status',
        'department_id',
        'created_by',
        'updated_by'
    ];

    const RECORDS_PER_PAGE = 20;

    const STATUS = ['pending','in_progress','solved'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
//            $model->updated_by = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
        });

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereHas('createdBy', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                });

            });
        }

    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }

    public function departmentQuery(): BelongsTo
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }


}
