<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MeetingParticipatorDetail
 *
 * @property int $id
 * @property int $team_meeting_id
 * @property int $meeting_participator_id
 * @property-read \App\Models\TeamMeeting $notice_id
 * @property-read \App\Models\User $participator
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingParticipatorDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingParticipatorDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingParticipatorDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingParticipatorDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingParticipatorDetail whereMeetingParticipatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MeetingParticipatorDetail whereTeamMeetingId($value)
 * @mixin \Eloquent
 */
class MeetingParticipatorDetail extends Model
{
    use HasFactory;

    protected $table = 'team_meeting_members';

    public $timestamps = false;

    protected $fillable = [
        'team_meeting_id',
        'meeting_participator_id'
    ];

    public function notice_id()
    {
        return $this->belongsTo(TeamMeeting::class, 'team_meeting_id', 'id');
    }

    public function participator()
    {
        return $this->belongsTo(User::class, 'meeting_participator_id', 'id');
    }
}
