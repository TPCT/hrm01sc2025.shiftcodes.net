<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $permission_key
 * @property int|null $permission_groups_id
 * @property-read \App\Models\PermissionGroup|null $permissionGroup
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission wherePermissionGroupsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission wherePermissionKey($value)
 * @mixin \Eloquent
 */
class Permission extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "permissions";

    protected $fillable = [
        'name',
        'permission_key',
        'permission_groups_id'
    ];

    public function permissionGroup(): BelongsTo
    {
        return $this->belongsTo(PermissionGroup::class, 'permission_groups_id', 'id');
    }

}
