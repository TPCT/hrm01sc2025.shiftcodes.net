<?php

namespace App\Services\Qr;

use App\Repositories\QRCodeRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class QrCodeService
{

    public function __construct(public QRCodeRepository $QRCodeRepository)
    {
    }

    public function getAllQr()
    {
        return $this->QRCodeRepository->getAll();
    }

    public function verifyQr($identifier)
    {
        return $this->QRCodeRepository->getAll($identifier);
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function findQrDetailById($id): mixed
    {
        return $this->QRCodeRepository->findQr($id);
    }

    /**
     * @throws Exception
     */
    public function saveQrDetail($validatedData)
    {


        $identifier = $validatedData['branch_id'] . random_bytes(20);
        $validatedData['identifier'] = base64_encode($identifier);


        return $this->QRCodeRepository->store($validatedData);

    }

    /**
     * @throws Exception
     */
    public function updateQrDetail($validatedData, $id): bool
    {

        $qrDetail = $this->findQrDetailById($id);

        return $this->QRCodeRepository->update($qrDetail, $validatedData);

    }


    /**
     * @throws Exception
     */
    public function deleteQrDetail($id): bool
    {

        $qrDetail = $this->findQrDetailById($id);

        $this->QRCodeRepository->delete($qrDetail);

        return true;

    }


}

