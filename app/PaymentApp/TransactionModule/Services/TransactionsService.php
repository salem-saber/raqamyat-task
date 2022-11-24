<?php

namespace PaymentApp\TransactionModule\Services;

use PaymentApp\Base\Service;
use PaymentApp\TransactionModule\Mappers\TransactionDTOMapper;
use PaymentApp\TransactionModule\Repositories\TransactionRepository;
use Illuminate\Contracts\Pagination\Paginator;

class TransactionsService extends Service
{
    private TransactionRepository $transactionRepository;
    public function __construct()
    {
        $this->transactionRepository = new TransactionRepository();
    }


    public function getTransactions(
        array|string $statuses = [],
        array|string $currencies = [],
        ?float $minAmount = null,
        ?float $maxAmount = null,
        string $dateFrom = '',
        string $dateTo = '',
        int $pageSize = 10,
        int $pageNo = 1,
    ): ?Paginator
    {
        $statuses = !is_array($statuses) ? [$statuses] : $statuses;
        $currencies = !is_array($currencies) ? [$currencies] : $currencies;

        /** clean string - handling sql injection
         * @see cleanString()
        */
        $statuses = array_map('cleanString', $statuses);
        $currencies = array_map('cleanString', $currencies);

        /** upper case statuses & currencies to be like in the database
         * @see TransactionStatus
         */
        $statuses = array_map('strtoupper', $statuses);
        $currencies = array_map('strtoupper', $currencies);

        // get filtered users
        $data = $this->transactionRepository->getTransactions(
            $statuses,
            $currencies,
            $minAmount,
            $maxAmount,
            $dateFrom,
            $dateTo,
            $pageSize,
            $pageNo
        );

        // map users to produce clean API response
        $collection = $data->getCollection();
        $mappedData = $collection->map(function ($transaction) {
            $userDTOMapper = new TransactionDTOMapper();
            return $userDTOMapper->setTransaction($transaction)->map()->get();
        });
        $data->setCollection($mappedData);
        return $data;
    }
}
