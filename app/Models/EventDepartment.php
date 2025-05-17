<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\EventDepartment
 *
 * @property int $id
 * @property int $event_id
 * @property int $department_id
 * @property-read \App\Models\Department $department
 * @property-read \App\Models\Event $event
 * @method static \Illuminate\Database\Eloquent\Builder|EventDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventDepartment whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventDepartment whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventDepartment whereId($value)
 * @mixin \Eloquent
 */
class EventDepartment extends Model
{
    use HasFactory;
    protected $table = 'event_departments';

    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'department_id'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
