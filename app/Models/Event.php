<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $title
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string $description
 * @property string $location
 * @property string|null $attachment
 * @property int $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $background_color
 * @property string|null $host
 * @property string|null $status
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventDepartment> $eventDepartment
 * @property-read int|null $event_department_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EventUser> $eventUser
 * @property-read int|null $event_user_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|Event whereAttachment($value)
 * @method static Builder|Event whereBackgroundColor($value)
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereCreatedBy($value)
 * @method static Builder|Event whereDescription($value)
 * @method static Builder|Event whereEndDate($value)
 * @method static Builder|Event whereEndTime($value)
 * @method static Builder|Event whereHost($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereLocation($value)
 * @method static Builder|Event whereStartDate($value)
 * @method static Builder|Event whereStartTime($value)
 * @method static Builder|Event whereStatus($value)
 * @method static Builder|Event whereTitle($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @method static Builder|Event whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    use HasFactory;
    protected $table = 'events';

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'location',
        'description',
        'attachment',
        'created_by',
        'updated_by',
        'start_time',
        'end_time',
        'background_color',
        'host',
        'status'
    ];

    const RECORDS_PER_PAGE = 20;

    const UPLOAD_PATH = 'uploads/events/';

    public static function boot()
    {
        parent::boot();

        if (Auth::check() && Auth::user()->id != 1 && isset(Auth::user()->branch_id)) {
            $branchId = Auth::user()->branch_id;

            static::addGlobalScope('branch', function (Builder $builder) use($branchId){
                $builder->whereHas('EventUser.employee', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                });

            });
        }
    }

    public function eventDepartment()
    {
        return $this->hasMany(EventDepartment::class,'event_id','id');
    }

    public function eventUser()
    {
        return $this->hasMany(EventUser::class,'event_id','id');
    }
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

}
