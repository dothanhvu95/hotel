<?php

namespace App\Http\Requests;

use App\Exceptions\BaseException;
use App\Utils\Result;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

abstract class BaseRequest extends LaravelFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * @throws OkxeException
     */
    protected function failedValidation(Validator $validator)
    {
        $errorsReturn = (new ValidationException($validator))->errors();
        $validateError = null;
        if (!empty($errorsReturn)) {
            $errors = Arr::first($errorsReturn);
            if (!empty($errors)) {
                $validateError = Arr::first($errors);
            }
        }

        throw new BaseException(
            Result::VALIDATE_ERROR,
            $validateError,
            $errorsReturn
        );
    }
}
