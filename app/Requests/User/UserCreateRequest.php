<?php

namespace App\Requests\User;



use App\Helpers\AppHelper;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserCreateRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge([
            'joining_date' => $this->input('joining_date') ? AppHelper::getEnglishDate($this->input('joining_date')) : null,
            'dob' => $this->input('dob') ? AppHelper::getEnglishDate($this->input('dob')) : null,
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_code'=>'nullable',
            'name'=>'required|string|max:100|min:2',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:4',
            'username'=>'required|string|unique:users',
            'address'=>'nullable|required_unless:role_id,1',
            'dob' => 'nullable|required_unless:role_id,1|date|before:today',
            'phone'=>'nullable|required_unless:role_id,1|numeric',
            'gender' => ['nullable', 'required_unless:role_id,1', 'string', Rule::in(User::GENDER)],
            'marital_status' => ['nullable','required_unless:role_id,1', 'string', Rule::in(User::MARITAL_STATUS)],
            'employment_type' => ['nullable','required_unless:role_id,1', 'string', Rule::in(User::EMPLOYMENT_TYPE)],
            'joining_date' => 'nullable|date|before_or_equal:today',
            'role_id' => 'required|exists:roles,id',
            'branch_id' => 'nullable|required_unless:role_id,1|exists:branches,id',
            'department_id' => 'nullable|required_unless:role_id,1|exists:departments,id',
            'post_id' => 'nullable|required_unless:role_id,1|exists:posts,id',
            'supervisor_id' => 'nullable|exists:users,id',
            'office_time_id' => 'nullable|required_unless:role_id,1|exists:office_times,id',
            'leave_allocated' => 'nullable|numeric|gte:0',
            'remarks' => 'nullable|string|max:1000',
            'workspace_type' => ['nullable', 'boolean', Rule::in([1, 0])],
            'avatar' => ['required', 'file', 'mimes:jpeg,png,jpg,webp','max:5048'],
        ];

    }
    public function messages()
    {
        return [
            'required_unless' => 'The :attribute field is required',
        ];
    }

    public function attributes()
    {
        return [
            'dob' => 'date of birth',
            'phone' => 'phone number',
            'gender' => 'gender',
            'marital_status' => 'marital status',
            'employment_type' => 'employment type',
            'branch_id' => 'branch',
            'department_id' => 'department',
            'post_id' => 'post',
            'office_time_id' => 'office time',
        ];
    }


}














