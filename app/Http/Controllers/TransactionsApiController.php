<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use PaymentApp\Base\ResponseBuilder;
use PaymentApp\Base\Traits\HandelServiceResponse;
use PaymentApp\TransactionModule\Requests\GetTransactionsRequest;
use PaymentApp\TransactionModule\Services\TransactionsService;

class TransactionsApiController extends Controller
{
    use HandelServiceResponse;
    protected ResponseBuilder $responseBuilder;
    private TransactionsService $transactionsService;


    public function __construct(TransactionsService $transactionsService)
    {
        $this->responseBuilder = new ResponseBuilder();
        $this->transactionsService = $transactionsService;

    }

    public function getTransactions(GetTransactionsRequest $request): JsonResponse
    {
        $requestData = $request->all();
        $data = $this->transactionsService->getTransactions(
            statuses: $requestData['status']??[],
            currencies: $requestData['currency']??[],
            minAmount: $requestData['minAmount']??null,
            maxAmount: $requestData['maxAmount']??null,
            dateFrom: $requestData['dateFrom']??'',
            dateTo: $requestData['dateTo']??'',
            pageSize: $requestData['pageSize']??10,
            pageNo: $requestData['pageNo']??1,
        );

        return $this->getServiceResponse($this->transactionsService,$data);
    }

}
