<?php

namespace App\Http\Requests\Tenants\StaffManagement;

use Illuminate\Foundation\Http\FormRequest;

class DestroyStaffManagementRole extends FormRequest
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
            'role_id' => 'required|exists:tenant.roles,id',
            'user_id' => 'required|exists:tenant.users,id',
        ];
    }
}
