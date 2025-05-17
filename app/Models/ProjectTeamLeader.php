<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ProjectTeamLeader
 *
 * @property int $id
 * @property int $project_id
 * @property int $leader_id
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTeamLeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTeamLeader newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTeamLeader query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTeamLeader whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTeamLeader whereLeaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProjectTeamLeader whereProjectId($value)
 * @mixin \Eloquent
 */
class ProjectTeamLeader extends Model
{
    use HasFactory;

    protected $table = 'project_team_leaders';

    public $timestamps = false;

    protected $fillable = [
        'project_id',
        'leader_id'
    ];


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id', 'id');
    }
}
