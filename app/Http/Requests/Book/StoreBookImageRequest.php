<?php

namespace App\Http\Requests\Book;

use App\Enums\ImageStatusEnum;
use App\Enums\LanguagesEnum;
use App\Traits\ErrorsToJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookImageRequest extends FormRequest
{
    use ErrorsToJson;

    public function rules(): array
    {
        return [
            'image' => ['required', 'image:jpg,jpeg,png'],
            'language' => [
                'required',
                Rule::in(array_map(fn($case) => $case->value, LanguagesEnum::cases())),
            ],
            'book_id' => ['required', 'exists:books,id']
        ];
    }
    protected function failedValidation(Validator $validator): void
    {
        self::Respond($validator);
    }
}