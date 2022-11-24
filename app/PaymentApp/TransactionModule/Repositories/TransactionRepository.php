<?php

namespace PaymentApp\TransactionModule\Repositories;

use Illuminate\Contracts\Pagination\Paginator;
use PaymentApp\Base\Repository;
use PaymentApp\TransactionModule\Models\Transaction;

class TransactionRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(new Transaction());
    }

    public function getTransactions(
        array  $statuses = [],
        array  $currencies = [],
        ?float $minAmount = null,
        ?float $maxAmount = null,
        string $dateFrom = '',
        string $dateTo = '',
        int    $pageSize = 10,
        int    $pageNo = 1,
    ): ?Paginator
    {
        return $this->getModel()->query()->where(function ($query) use ($statuses, $currencies, $minAmount, $maxAmount, $dateFrom, $dateTo) {
            if (!empty($statuses)) {
                $query->whereIn('status', $statuses);
            }
            if (!empty($currencies)) {
                $query->whereIn('currency', $currencies);
            }
            if ($minAmount) {
                $query->where('paid_amount', '>=', $minAmount);
            }
            if ($maxAmount) {
                $query->where('paid_amount', '<=', $maxAmount);
            }
            if (!empty($dateFrom)) {
                $query->whereDate('payment_date', '>=', $dateFrom);
            }
            if (!empty($dateTo)) {
                $query->whereDate('payment_date', '<=', $dateTo);
            }
        })->simplePaginate($pageSize, ['*'], 'page', $pageNo);
    }
}
