<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\TeamMeeting
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $venue
 * @property string $meeting_date
 * @property string $meeting_start_time
 * @property int $company_id
 * @property string|null $image
 * @property string $meeting_published_at
 * @property int $created_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MeetingParticipatorDetail> $teamMeetingParticipator
 * @property-read int|null $team_meeting_participator_count
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereMeetingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereMeetingPublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereMeetingStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamMeeting whereVenue($value)
 * @mixin \Eloquent
 */
class TeamMeeting extends Model
{
    use HasFactory;

    protected $table = 'team_meetings';

    protected $fillable = [
        'title',
        'description',
        'venue',
        'meeting_date',
        'meeting_start_time',
        'image',
        'company_id',
        'meeting_published_at',
        'created_by',
        'updated_by',
    ];

    const RECORDS_PER_PAGE = 20;

    const UPLOAD_PATH = 'uploads/team-meeting/';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::user()->id;
            $model->meeting_published_at = Carbon::now()->format('Y-m-d H:i:s');
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id;
            $model->meeting_published_at = Carbon::now()->format('Y-m-d H:i:s');
        });

        static::deleting(function($meetingDetail) {
            $meetingDetail->teamMeetingParticipator()->delete();
        });

    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function teamMeetingParticipator()
    {
        return $this->hasMany(MeetingParticipatorDetail::class,'team_meeting_id','id')->whereHas('participator');
    }
}
