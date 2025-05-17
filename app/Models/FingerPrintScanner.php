<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FingerPrintScanner extends Model
{
    use HasFactory;

    protected $table = 'fingerprint_scanners';

    protected $fillable  = [
        'company_id',
        'branch_id',
        'ip',
        'port'
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
