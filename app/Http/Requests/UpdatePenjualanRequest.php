<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenjualanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->request->replace($this->only([
            'user_id',
            'pembeli',
            'penjualan_kode',
        ]));
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'bail|exists:m_user|integer',
            'pembeli' => 'bail|string|max:20',
            'penjualan_kode' => 'bail|unique:t_penjualan',
            'tanggal_penjualan' => 'bail|date_format:Y-m-d H-i-s'
        ];
    }
}
