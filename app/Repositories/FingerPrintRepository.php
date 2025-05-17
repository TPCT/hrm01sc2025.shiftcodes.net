<?php

namespace App\Repositories;

use App\Models\FingerPrintScanner;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;

class FingerPrintRepository
{
    const IS_ACTIVE = 1;

    public function getAllFingerPrintScanners($select=['*'],$with=[])
    {
        $branchId = auth()->user()->branch_id;
        $authUserId = auth()->user()->id;

        return FingerPrintScanner::with($with)->select($select)
            ->when(isset($branchId) && ($authUserId != 1), function ($query) use ($branchId) {
                $query->where('branch_id', $branchId);
            })
            ->latest()->paginate(FingerPrintScanner::RECORDS_PER_PAGE);
    }

    public function findRouterDetailByBranchId($authUserBranchId,$with=[],$select=['*'])
    {
        return FingerPrintScanner::with($with)
                    ->select($select)
                    ->where('branch_id',$authUserBranchId)
                    ->first();
    }

    public function findFingerPrintScannerIp($ip)
    {
        return FingerPrintScanner::where('ip',$ip)->first();
    }

    private function createFingerPrintUser(FingerPrintScanner $fingerprintScanner){
        $fingerprintScanner->user()->create([
            'name' => $fingerprintScanner->fingerprint_username,
            'email' => Str::random() . '@gmail.com',
            'username' => $fingerprintScanner->fingerprint_username,
            'password' => Hash::make($fingerprintScanner->fingerprint_password),
            'company_id' => $fingerprintScanner->company_id,
            'branch_id' => $fingerprintScanner->branch_id,
            'is_active' => 1
        ]);
    }

    public function store($validatedData)
    {
        $validatedData['fingerprint_username'] = "fingerprint_user_" . Str::random(5);
        $validatedData['fingerprint_password'] = Str::random();
        $fingerprintScanner = FingerPrintScanner::create($validatedData)->fresh();
        $this->createFingerPrintUser($fingerprintScanner);
        return $fingerprintScanner;
    }

    public function findFingerPrintScannerById($id)
    {
        return FingerPrintScanner::where('id',$id)->first();
    }

    public function delete(FingerPrintScanner $fingerprintDetail)
    {
        $fingerprintDetail->user->delete();
        return $fingerprintDetail->delete();
    }

    public function update(FingerPrintScanner $fingerprintDetail,$validatedData)
    {
        $fingerprintDetail->update($validatedData);
        if (!$fingerprintDetail->user)
            $this->createFingerPrintUser($fingerprintDetail);
    }
}
