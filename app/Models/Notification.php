<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Notification
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $type
 * @property string $notification_publish_date
 * @property int|null $notification_for_id
 * @property int $is_active
 * @property int $company_id
 * @property int $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserNotification> $notifiedUsers
 * @property-read int|null $notified_users_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Notification newModelQuery()
 * @method static Builder|Notification newQuery()
 * @method static Builder|Notification query()
 * @method static Builder|Notification whereCompanyId($value)
 * @method static Builder|Notification whereCreatedAt($value)
 * @method static Builder|Notification whereCreatedBy($value)
 * @method static Builder|Notification whereDescription($value)
 * @method static Builder|Notification whereId($value)
 * @method static Builder|Notification whereIsActive($value)
 * @method static Builder|Notification whereNotificationForId($value)
 * @method static Builder|Notification whereNotificationPublishDate($value)
 * @method static Builder|Notification whereTitle($value)
 * @method static Builder|Notification whereType($value)
 * @method static Builder|Notification whereUpdatedAt($value)
 * @method static Builder|Notification whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    use HasFactory;

    const RECORDS_PER_PAGE = 20;

    const TYPES = [
        'general',
        'comment',
        'project',
        'task',
        'attendance',
        'leave',
        'support',
        'tada',
        'holiday',
        'payroll',
        'resignation',
        'termination'
    ];

    protected $table = 'notifications';

    protected $fillable = [
        'title',
        'description',
        'type',
        'notification_for_id',
        'notification_publish_date',
        'company_id',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
            $model->notification_publish_date = Carbon::now()->format('Y-m-d H:i:s');
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
            $model->notification_publish_date = Carbon::now()->format('Y-m-d H:i:s');
        });

        static::deleting(function($notifiedUserDetail){
            $notifiedUserDetail->notifiedUsers()->delete();
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

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function notifiedUsers(): HasMany
    {
        return $this->hasMany(UserNotification::class, 'notification_id', 'id');
    }

}
