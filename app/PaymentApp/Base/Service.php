<?php

namespace PaymentApp\Base;


class Service
{

    private array $errors = [];

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param mixed $errors
     */
    public function setErrors(mixed $errors): void
    {
        if(is_array($errors))
            $this->errors = array_merge($this->errors,$errors);
        else
            $this->errors[] = $errors;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * @return void
     */
    public static function startTransaction(): void
    {
        Repository::startTransaction();
    }

    /**
     * @return void
     */
    public static function commitTransaction(): void
    {
        Repository::commitTransaction();
    }

    /**
     * @return void
     */
    public static function rollbackTransaction(): void
    {
        Repository::rollbackTransaction();
    }
}
