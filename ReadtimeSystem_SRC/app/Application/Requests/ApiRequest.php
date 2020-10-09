<?php

namespace App\Application\Requests;

use App\Application\Responses\Api\BaseApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * API用リクエスト
 */
abstract class ApiRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     * @throw HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $erros = implode("\n", $validator->errors()->all());
        $res = new BaseApiResponse();
        $res->apiFailed(422, $erros);

        throw new HttpResponseException(response()->json($res, 422));
    }
}
