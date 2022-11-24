<?php

namespace PaymentApp\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use PaymentApp\TransactionModule\Contexts\TransactionStatus;
use PaymentApp\TransactionModule\Repositories\TransactionRepository;
use pcrov\JsonReader\JsonReader;

class InsertProviderData extends Command
{
    protected JsonReader $jsonReader;
    protected TransactionRepository $transactionRepository;


    protected $signature = 'insert:provider-data';

    protected $description = 'Import user and transactions data from json to database';

    public function __construct()
    {
        parent::__construct();
        $this->jsonReader = new JsonReader();
        $this->transactionRepository = new TransactionRepository();
    }


    public function handle(): void
    {
        $this->info('Start importing data from json files to database');
        $this->importTransactions();
    }

    public function importTransactions()
    {

        $this->providerDataW();
        $this->providerDataX();
        $this->providerDataY();
    }

    public function providerDataW()
    {
        $this->info('transactions Data W file...');
        if (!Storage::disk('provider')->exists('DataW.json')) {
            $this->error('transactions : ' . __('file.not_found'));
            return;
        }
        $path = storage_path('provider/DataW.json');
        $this->jsonReader->open($path);
        $depth = $this->jsonReader->depth(); // Check in a moment to break when the array is done.
        $this->jsonReader->read(); // Step to the first object.
        do {
            $data = $this->jsonReader->value();
            $this->withProgressBar($data['transactions'], function ($transaction) {
                $this->performImportingTransactionsProviderDataW($transaction);
            });

        } while ($this->jsonReader->next() && $this->jsonReader->depth() > $depth); // Read each sibling.

        $this->jsonReader->close();
    }

    public function performImportingTransactionsProviderDataW($data)
    {
        $this->transactionRepository->create([
            'amount' => $data['amount'],
            'mobile' => $data['mobile'],
            'currency' => $data['currency'],
            'status' => ($data['status'] == 'done') ? TransactionStatus::PAID : TransactionStatus::REJECT,
            'payment_date' => $data['created_at'],
            'provider_type' => 'DataW',
            'provider_id' => $data['id'],

        ]);
    }


    public function providerDataX()
    {
        $this->info('transactions Data X file...');
        if (!Storage::disk('provider')->exists('DataX.json')) {
            $this->error('transactions : ' . __('file.not_found'));
            return;
        }
        $path = storage_path('provider/DataX.json');
        $this->jsonReader->open($path);
        $depth = $this->jsonReader->depth(); // Check in a moment to break when the array is done.
        $this->jsonReader->read(); // Step to the first object.
        do {
            $data = $this->jsonReader->value();
            $this->withProgressBar($data['transactions'], function ($transaction) {
                $this->performImportingTransactionsProviderDataX($transaction);
            });

        } while ($this->jsonReader->next() && $this->jsonReader->depth() > $depth); // Read each sibling.

        $this->jsonReader->close();
    }

    public function performImportingTransactionsProviderDataX($data)
    {
        $this->transactionRepository->create([
            'amount' => $data['transactionAmount'],
            'mobile' => $data['mobile'],
            'currency' => $data['currency'],
            'status' => TransactionStatus::PAID,
            'payment_date' => $data['date'],
            'provider_type' => 'DataX',
            'provider_id' => $data['transaction_id'],
        ]);
    }

    public function providerDataY()
    {
        $this->info('transactions Data Y file...');
        if (!Storage::disk('provider')->exists('DataY.json')) {
            $this->error('transactions : ' . __('file.not_found'));
            return;
        }
        $path = storage_path('provider/DataY.json');
        $this->jsonReader->open($path);
        $depth = $this->jsonReader->depth(); // Check in a moment to break when the array is done.
        $this->jsonReader->read(); // Step to the first object.
        do {
            $data = $this->jsonReader->value();
            $this->withProgressBar($data['transactions'], function ($transaction) {
                $this->performImportingTransactionsProviderDataY($transaction);
            });

        } while ($this->jsonReader->next() && $this->jsonReader->depth() > $depth); // Read each sibling.

        $this->jsonReader->close();
    }

    public function performImportingTransactionsProviderDataY($data)
    {
        $this->transactionRepository->create([
            'amount' => $data['amount'],
            'mobile' => $data['mobile'],
            'currency' => $data['currency'],
            'status' => ($data['status'] == 100) ? TransactionStatus::PAID : TransactionStatus::REJECT,
            'payment_date' => $data['created_at'],
            'provider_type' => 'DataY',
            'provider_id' => $data['id'],
        ]);
    }
}

