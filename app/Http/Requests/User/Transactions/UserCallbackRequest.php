<?php

namespace App\Http\Requests\User\Transactions;

use Illuminate\Foundation\Http\FormRequest;

class UserCallbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'required|',
            'ref_id' => 'required|integer|exists:wallet_payments,ref_id',
        ];
    }
}
