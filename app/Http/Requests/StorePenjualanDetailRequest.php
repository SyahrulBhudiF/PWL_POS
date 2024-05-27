<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class StorePenjualanDetailRequest extends FormRequest
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
            'barang_id',
            'jumlah'
        ]));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        foreach ($this->input('barang_id') as $index => $barang_id) {
            $rules['barang_id.' . $index] = 'bail|required|integer|exists:m_barang,barang_id';
            $rules['jumlah.' . $index] = [
                'bail',
                'required',
                'integer',
                function ($attribute, $value) use ($barang_id, $index) {
                    $stok_jumlah = DB::table('t_stok')
                        ->where('barang_id', $barang_id)
                        ->value('stok_jumlah');

                    if ($value > $stok_jumlah) {
                        throw new HttpResponseException(response()->json([
                            'success' => false,
                            'message' => 'Penjualan Detail Validation data failed',
                            'errors' => $attribute . ' index must be less than or equal to stok_jumlah = ' . $stok_jumlah . ' in t_stok'
                        ], 422));
                    }
                    $this->merge([
                        'harga' . $index => DB::table('m_barang')
                            ->where('barang_id', '=', $barang_id)
                            ->value('harga_jual')
                    ]);
                },
            ];
        }

        return $rules;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Penjualan Detail Validation data failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
