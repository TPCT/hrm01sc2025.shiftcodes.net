<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Branch
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property int|null $branch_head_id
 * @property int $company_id
 * @property float|null $branch_location_latitude
 * @property float|null $branch_location_longitude
 * @property int $is_active
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $branchHead
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Router> $routers
 * @property-read int|null $routers_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Branch newModelQuery()
 * @method static Builder|Branch newQuery()
 * @method static Builder|Branch query()
 * @method static Builder|Branch whereAddress($value)
 * @method static Builder|Branch whereBranchHeadId($value)
 * @method static Builder|Branch whereBranchLocationLatitude($value)
 * @method static Builder|Branch whereBranchLocationLongitude($value)
 * @method static Builder|Branch whereCompanyId($value)
 * @method static Builder|Branch whereCreatedAt($value)
 * @method static Builder|Branch whereCreatedBy($value)
 * @method static Builder|Branch whereId($value)
 * @method static Builder|Branch whereIsActive($value)
 * @method static Builder|Branch whereName($value)
 * @method static Builder|Branch wherePhone($value)
 * @method static Builder|Branch whereUpdatedAt($value)
 * @method static Builder|Branch whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'branch_head_id',
        'company_id',
        'branch_location_latitude',
        'branch_location_longitude',
        'is_active',
        'created_by',
        'updated_by'
    ];

    const RECORDS_PER_PAGE = 10;

    const UPLOAD_PATH = 'uploads/branch/';

    const IS_ACTIVE = 1;

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

        if (Auth::check() && Auth::user()->id != 1) {
            static::addGlobalScope('branch', function (Builder $builder) {
                $user = Auth::user();
                if (isset($user->branch_id)) {
                    $branchId = $user->branch_id;
                    $builder->where('id', $branchId);
                }
            });
        }

    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'updated_by','id');
    }

    public function branchHead(): BelongsTo
    {
        return $this->belongsTo(User::class,'branch_head_id','id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class,'branch_id','id');
    }

    public function routers(): HasMany
    {
        return $this->hasMany(Router::class,'branch_id','id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(User::class,'branch_id','id')
            ->where([
                ['status', '=', 'verified'],
                ['is_active', '=', self::IS_ACTIVE ],
            ]);
    }

}
