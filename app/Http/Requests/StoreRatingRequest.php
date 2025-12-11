<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'kos_id' => 'required|exists:kos,id',
            'rating' => 'required|integer|between:1,5',
            'ulasan' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'kos_id.required' => 'Kos harus dipilih',
            'kos_id.exists' => 'Kos tidak ditemukan',
            'rating.required' => 'Rating harus diisi',
            'rating.integer' => 'Rating harus berupa angka',
            'rating.between' => 'Rating harus antara 1-5',
            'ulasan.max' => 'Ulasan maksimal 500 karakter',
        ];
    }
}
