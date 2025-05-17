<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Award
 *
 * @property int $id
 * @property int $employee_id
 * @property int $award_type_id
 * @property string $gift_item
 * @property string|null $award_base
 * @property string $awarded_date
 * @property string|null $awarded_by
 * @property int $status
 * @property string|null $award_description
 * @property string|null $gift_description
 * @property string|null $attachment
 * @property string|null $reward_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $employee
 * @property-read \App\Models\AwardType $type
 * @method static Builder|Award newModelQuery()
 * @method static Builder|Award newQuery()
 * @method static Builder|Award query()
 * @method static Builder|Award whereAttachment($value)
 * @method static Builder|Award whereAwardBase($value)
 * @method static Builder|Award whereAwardDescription($value)
 * @method static Builder|Award whereAwardTypeId($value)
 * @method static Builder|Award whereAwardedBy($value)
 * @method static Builder|Award whereAwardedDate($value)
 * @method static Builder|Award whereCreatedAt($value)
 * @method static Builder|Award whereEmployeeId($value)
 * @method static Builder|Award whereGiftDescription($value)
 * @method static Builder|Award whereGiftItem($value)
 * @method static Builder|Award whereId($value)
 * @method static Builder|Award whereRewardCode($value)
 * @method static Builder|Award whereStatus($value)
 * @method static Builder|Award whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Award extends Model
{
    use HasFactory;

    protected $table = 'awards';
    protected $fillable = [
        'employee_id', 'award_type_id', 'gift_item', 'award_base', 'awarded_date', 'awarded_by', 'status', 'award_description', 'gift_description', 'attachment', 'reward_code',
    ];


    const RECORDS_PER_PAGE = 20;

    const UPLOAD_PATH = 'uploads/award/';

    public static function boot()
    {
        parent::boot();

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereHas('employee', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                });

            });
        }
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AwardType::class,'award_type_id','id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class,'employee_id','id');
    }

}
