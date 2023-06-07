<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class FileStoreRequest extends FormRequest
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
            'file' => [
                'required', File::image()->types(['image/jpeg', 'image/png'])
            ]
        ];
    }
}
