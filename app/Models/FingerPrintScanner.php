<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FingerPrintScanner
 *
 * @property int $id
 * @property int $company_id
 * @property int $branch_id
 * @property string $ip
 * @property int $port
 * @property string|null $password
 * @property string|null $fingerprint_username
 * @property string|null $fingerprint_password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner query()
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner whereFingerprintPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner whereFingerprintUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FingerPrintScanner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FingerPrintScanner extends Model
{
    use HasFactory;

    protected $table = 'fingerprint_scanners';

    protected $fillable  = [
        'company_id',
        'branch_id',
        'ip',
        'port',
        'password',
        'fingerprint_username',
        'fingerprint_password',
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

    public function user(){
        return $this->hasOne(User::class, 'username', 'fingerprint_username');
    }
}
