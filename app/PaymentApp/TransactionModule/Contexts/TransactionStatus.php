<?php

namespace PaymentApp\TransactionModule\Contexts;

use ReflectionClass;

class TransactionStatus
{
    const PENDING = 'PENDING';
    const PAID = 'PAID';
    const REJECT = 'REJECT';

    public static function listReadable(): array
    {
        return [
            self::PENDING => __('status.Pending'),
            self::PAID => __('status.Paid'),
            self::REJECT => __('status.Reject'),
        ];
    }

    public static function get(string $status): string
    {
        return self::listReadable()[$status];
    }


}
