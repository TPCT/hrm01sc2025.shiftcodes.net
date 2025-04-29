<?php

namespace App\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserAttachmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'attachments.*.value' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:5000',
            'attachments.*.type' => 'required|in:ID,Criminal Record,Academic Qualification,Employment Contract,Trust Receipt,Other 1,Other 2',
        ];

    }

}















