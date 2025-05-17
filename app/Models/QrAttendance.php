<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * App\Models\QrAttendance
 *
 * @property int $id
 * @property string $title
 * @property string $identifier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $branch_id
 * @property int|null $department_id
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\Department|null $department
 * @property-read mixed $qr_code
 * @method static Builder|QrAttendance newModelQuery()
 * @method static Builder|QrAttendance newQuery()
 * @method static Builder|QrAttendance query()
 * @method static Builder|QrAttendance whereBranchId($value)
 * @method static Builder|QrAttendance whereCreatedAt($value)
 * @method static Builder|QrAttendance whereDepartmentId($value)
 * @method static Builder|QrAttendance whereId($value)
 * @method static Builder|QrAttendance whereIdentifier($value)
 * @method static Builder|QrAttendance whereTitle($value)
 * @method static Builder|QrAttendance whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QrAttendance extends Model
{
    use HasFactory;

    protected $table = 'qr_attendances';

    protected $fillable = ['title','identifier','branch_id','department_id'];

    protected $appends = ['qr_code'];

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
    public function getQrCodeAttribute()
    {
        return QrCode::size(480)->generate($this->identifier);
    }


    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }
}
