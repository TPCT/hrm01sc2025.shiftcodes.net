<?php

namespace App\Repositories;

use App\Models\AwardType;

class AwardTypeRepository
{

    public function getAllAwardTypes($select=['*'],$with=[])
    {
        return AwardType::select($select)->withCount($with)->get();
    }

    public function getAllActiveAwardTypes($select=['*'])
    {
        return AwardType::select($select)->where('status',1)->get();
    }

    public function findAwardTypeById($id,$select=['*'],$with=[])
    {
        return AwardType::with($with)->select($select)->where('id',$id)->first();
    }

    public function create($validatedData)
    {
        return AwardType::create($validatedData)->fresh();
    }

    public function update($awardTypeDetail,$validatedData)
    {
        return $awardTypeDetail->update($validatedData);
    }

    public function delete($awardTypeDetail)
    {
        return $awardTypeDetail->delete();
    }

    public function toggleStatus($awardTypeDetail)
    {
        return $awardTypeDetail->update([
            'status' => !$awardTypeDetail->status,
        ]);
    }
}
