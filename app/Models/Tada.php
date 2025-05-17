<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Tada
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property float $total_expense
 * @property string $status
 * @property int $is_active
 * @property int $is_settled
 * @property string|null $remark
 * @property int $employee_id
 * @property int|null $verified_by
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TadaAttachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User $employeeDetail
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \App\Models\User|null $verifiedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Tada newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tada newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tada query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereIsSettled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereTotalExpense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tada whereVerifiedBy($value)
 * @mixin \Eloquent
 */
class Tada extends Model
{
    use HasFactory;

    const RECORDS_PER_PAGE = 20;

    const STATUS = ['pending', 'accepted', 'rejected'];

    protected $table = 'tadas';

    protected $fillable = [
        'title',
        'description',
        'total_expense',
        'status',
        'is_active',
        'is_settled',
        'remark',
        'employee_id',
        'verified_by',
        'created_by',
        'updated_by'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
            $model->updated_by = Auth::user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
        });

        static::deleting(function ($tadaDetail) {
            $tadaDetail->attachments()->delete();
        });
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by', 'id');
    }

    public function employeeDetail(): BelongsTo
    {
        return $this->belongsTo(User::class,'employee_id','id');

    }


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TadaAttachment::class, 'tada_id', 'id');
    }

}
