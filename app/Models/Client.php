<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $contact_no
 * @property string $avatar
 * @property string|null $address
 * @property string $country
 * @property int $is_active
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $branch_id
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Client newModelQuery()
 * @method static Builder|Client newQuery()
 * @method static Builder|Client query()
 * @method static Builder|Client whereAddress($value)
 * @method static Builder|Client whereAvatar($value)
 * @method static Builder|Client whereBranchId($value)
 * @method static Builder|Client whereContactNo($value)
 * @method static Builder|Client whereCountry($value)
 * @method static Builder|Client whereCreatedAt($value)
 * @method static Builder|Client whereCreatedBy($value)
 * @method static Builder|Client whereEmail($value)
 * @method static Builder|Client whereId($value)
 * @method static Builder|Client whereIsActive($value)
 * @method static Builder|Client whereName($value)
 * @method static Builder|Client whereUpdatedAt($value)
 * @method static Builder|Client whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'email',
        'contact_no',
        'avatar',
        'address',
        'country',
        'is_active',
        'created_by',
        'updated_by',
        'branch_id'
    ];

    const RECORDS_PER_PAGE = 20;

    const UPLOAD_PATH = 'uploads/client/';

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
                $builder->whereNotNull('branch_id')
                    ->whereHas('branch', function ($query) use ($branchId) {
                        $query->where('id', $branchId);
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

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'client_id', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}

