<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Asset
 *
 * @property int $id
 * @property string $name
 * @property int $type_id
 * @property string $image
 * @property string|null $asset_code
 * @property string|null $asset_serial_no
 * @property string $is_working
 * @property string $purchased_date
 * @property int $warranty_available
 * @property string|null $warranty_end_date
 * @property int $is_available
 * @property int|null $assigned_to
 * @property string|null $assigned_date
 * @property string|null $note
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $assignedTo
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\AssetType $type
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Asset newModelQuery()
 * @method static Builder|Asset newQuery()
 * @method static Builder|Asset query()
 * @method static Builder|Asset whereAssetCode($value)
 * @method static Builder|Asset whereAssetSerialNo($value)
 * @method static Builder|Asset whereAssignedDate($value)
 * @method static Builder|Asset whereAssignedTo($value)
 * @method static Builder|Asset whereCreatedAt($value)
 * @method static Builder|Asset whereCreatedBy($value)
 * @method static Builder|Asset whereId($value)
 * @method static Builder|Asset whereImage($value)
 * @method static Builder|Asset whereIsAvailable($value)
 * @method static Builder|Asset whereIsWorking($value)
 * @method static Builder|Asset whereName($value)
 * @method static Builder|Asset whereNote($value)
 * @method static Builder|Asset wherePurchasedDate($value)
 * @method static Builder|Asset whereTypeId($value)
 * @method static Builder|Asset whereUpdatedAt($value)
 * @method static Builder|Asset whereUpdatedBy($value)
 * @method static Builder|Asset whereWarrantyAvailable($value)
 * @method static Builder|Asset whereWarrantyEndDate($value)
 * @mixin \Eloquent
 */
class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $fillable = [
        'name',
        'type_id',
        'image',
        'asset_code',
        'asset_serial_no',
        'is_working',
        'purchased_date',
        'warranty_available',
        'warranty_end_date',
        'is_available',
        'assigned_to',
        'assigned_date',
        'note',
        'created_by',
        'updated_by'
    ];

    const IS_WORKING = ['yes','no','maintenance'];

    const BOOLEAN_DATA = [
        0 => 'no',
        1 => 'yes'
    ];

    const RECORDS_PER_PAGE = 20;

    const UPLOAD_PATH = 'uploads/asset/';

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

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereHas('assignedTo', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                });

            });
        }
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AssetType::class,'type_id','id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class,'assigned_to','id')->withDefault();
    }

}
