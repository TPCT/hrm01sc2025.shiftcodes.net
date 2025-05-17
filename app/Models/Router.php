<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Router
 *
 * @property int $id
 * @property string $router_ssid
 * @property int $branch_id
 * @property int $company_id
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|Router newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Router newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Router query()
 * @method static \Illuminate\Database\Eloquent\Builder|Router whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Router whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Router whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Router whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Router whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Router whereRouterSsid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Router whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Router extends Model
{
    use HasFactory;

    protected $table = 'routers';

    protected $fillable = [
        'router_ssid',
        'company_id',
        'branch_id',
        'is_active'
    ];

    const RECORDS_PER_PAGE = 20;

    public function branch()
    {
        return $this->belongsTo(Branch::class,'branch_id','id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
