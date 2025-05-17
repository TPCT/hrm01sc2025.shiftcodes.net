<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\AwardType
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $branch_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Award> $awards
 * @property-read int|null $awards_count
 * @property-read \App\Models\Branch|null $branch
 * @method static Builder|AwardType newModelQuery()
 * @method static Builder|AwardType newQuery()
 * @method static Builder|AwardType query()
 * @method static Builder|AwardType whereBranchId($value)
 * @method static Builder|AwardType whereCreatedAt($value)
 * @method static Builder|AwardType whereId($value)
 * @method static Builder|AwardType whereStatus($value)
 * @method static Builder|AwardType whereTitle($value)
 * @method static Builder|AwardType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AwardType extends Model
{
    use HasFactory;

    protected $table = 'award_types';

    protected $fillable = [
        'title','status','branch_id'
    ];

    public static function boot()
    {
        parent::boot();

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereNotNull('branch_id')
                    ->whereHas('branch', function ($query) use ($branchId) {
                        $query->where('id', $branchId);
                    });

            });
        }
    }
    public function awards(): HasMany
    {
        return $this->hasMany(Award::class, 'award_type_id', 'id');
    }
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

}
