<?php

namespace PaymentApp\TransactionModule\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use PaymentApp\Base\ResponseBuilder;

class GetTransactionsRequest extends FormRequest
{
    protected ResponseBuilder $responseBuilder;


    public function __construct()
    {
        parent::__construct();
        $this->responseBuilder = new ResponseBuilder();
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'sometimes',
            'currency' => 'sometimes',
            'minAmount' => 'sometimes|numeric|min:0',
            'maxAmount' => 'sometimes|numeric|min:1|gt:minAmount',
            'dateFrom' => 'sometimes|date',
            'dateTo' => 'sometimes|date|after_or_equal:dateFrom',
            'pageSize' => 'sometimes|integer|min:1',
            'pageNo' => 'sometimes|integer|min:1',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $this->responseBuilder->setMessage($validator->messages()->first());
        $this->responseBuilder->setErrors($validator->messages()->all());
        $this->responseBuilder->setStatusCode(Response::HTTP_BAD_REQUEST);

        throw new ValidationException($validator, $this->responseBuilder->getResponse());
    }
}
