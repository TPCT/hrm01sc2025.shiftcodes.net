<?php

namespace App\Requests\FingerprintScanner;

use App\Models\FingerPrintScanner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FingerprintScannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'branch_id' => 'required|exists:branches,id',
            'ip' => 'required|string|ipv4',
            'port' => 'required|integer|between:1,65535',
            'password' => 'required|string'
        ];

    }

}













