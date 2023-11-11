<?php

namespace App\Http\Requests;

use App\Exceptions\TodoException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{
    private static string $COLUMN_NAME = 'name';
    private static string $COLUMN_DESCRIPTION = 'description';
    private static string $COLUMN_COMPLETED = 'completed';

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
        /**
         * TODO: currently we receive a 404 when the validation fails...
         *      instead we should give back an error object, with Http Response Status: 400
         */
        return [
            self::$COLUMN_NAME => 'string|required|max:80',
            self::$COLUMN_DESCRIPTION => 'string|max:750|nullable',
            self::$COLUMN_COMPLETED => 'required|boolean'
        ];
    }

    /**
     * Throws error if the validation fails.
     * @throws TodoException
     */
    protected function failedValidation(Validator $validator): TodoException
    {
        throw TodoException::invalidRequestBody();
    }
}
