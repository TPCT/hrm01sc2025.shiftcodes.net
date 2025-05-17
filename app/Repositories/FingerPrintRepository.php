<?php

namespace App\Repositories;

use App\Models\FingerPrintScanner;

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

    public function store($validatedData)
    {
        return FingerPrintScanner::create($validatedData)->fresh();
    }

    public function findFingerPrintScannerById($id)
    {
        return FingerPrintScanner::where('id',$id)->first();
    }

    public function delete($fingerprintDetail)
    {
        return $fingerprintDetail->delete();
    }

    public function update($fingerprintDetail,$validatedData)
    {
        return $fingerprintDetail->update($validatedData);
    }
}
