<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\AssetType
 *
 * @property int $id
 * @property string $name
 * @property int $is_active
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asset> $assets
 * @property-read int|null $assets_count
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|AssetType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssetType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssetType whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class AssetType extends Model
{
    use HasFactory;

    protected $table = 'asset_types';

    protected $fillable = [
        'name',
        'is_active',
        'created_by',
        'updated_by'
    ];

    const RECORDS_PER_PAGE = 20;

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
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'type_id', 'id');
    }

}
