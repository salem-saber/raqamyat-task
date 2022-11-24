<?php

namespace PaymentApp\TransactionModule\Mappers;

use PaymentApp\TransactionModule\Contexts\TransactionStatus;
use PaymentApp\TransactionModule\DTOs\TransactionDTO;
use PaymentApp\TransactionModule\Models\Transaction;

class TransactionDTOMapper
{
    protected TransactionDTO $transactionDTO;
    protected Transaction $transaction;

    /**
     * @param Transaction $transaction
     * @return TransactionDTOMapper
     */
    public function setTransaction(Transaction $transaction): TransactionDTOMapper
    {
        $this->transaction = $transaction;
        $this->transactionDTO = new TransactionDTO();
        return $this;
    }


    public function map(): static
    {
        $this->transactionDTO->setAmount($this->transaction->amount);
        $this->transactionDTO->setCurrency($this->transaction->currency);
        $this->transactionDTO->setStatus(TransactionStatus::get($this->transaction->status));
        $this->transactionDTO->setMobile($this->transaction->mobile);
        $this->transactionDTO->setPaymentDate($this->transaction->payment_date->setTimezone('UTC')->format('Y-m-d H:i:s'));
        $this->transactionDTO->setProviderType($this->transaction->provider_type);
        $this->transactionDTO->setProviderId($this->transaction->provider_id);

        return $this;
    }

    public function get(): TransactionDTO
    {
        return $this->transactionDTO;
    }
}
