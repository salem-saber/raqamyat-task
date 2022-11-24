<?php

namespace PaymentApp\Base;

use Symfony\Component\HttpFoundation\Response;

class ResponseBuilder
{
    private static $data        = null;
    private static $errors      = null;
    private static $message     = '';
    private static $status_code = Response::HTTP_OK;


    /**
     * @return int
     */
    public static function getStatusCode(): int
    {
        return self::$status_code;
    }

    /**
     * @param int $status_code
     */
    public static function setStatusCode(int $status_code): void
    {
        self::$status_code = $status_code;
    }

    /**
     * @return null
     */
    public static function getData()
    {
        return self::$data;
    }

    /**
     * @param null $data
     */
    public static function setData($data): void
    {
        self::$data = $data;
    }

    /**
     * @return mixed
     */
    public static function getErrors()
    {
        return self::$errors;
    }

    /**
     * @param mixed $errors
     */
    public static function setErrors($errors): void {
        self::$errors = $errors;
    }

    public static function setGenericErrors($errorMessage): void {
        $error = new \stdClass();
        $error->message = [$errorMessage];
        self::$errors = $error;
    }



    /**
     * @return mixed
     */
    public static function getMessage()
    {
        return self::$message;
    }

    /**
     * @param mixed $message
     */
    public static function setMessage(mixed $message): void
    {
        self::$message = $message;
    }


    public static function getResponse() {
        if(self::getData() == null)
            self::setData(new \stdClass());

        if(self::getErrors() == null)
            self::setErrors(new \stdClass());

        return response()->json(['data'=> self::getData(),'errors'=> self::getErrors(),'message'=> self::getMessage(),'status_code'=> self::getStatusCode()],self::getStatusCode());
    }

    public static function generateUnAuthorizedResponse() {
        self::setStatusCode(Response::HTTP_UNAUTHORIZED);
        self::setErrors([Response::$statusTexts[Response::HTTP_UNAUTHORIZED]]);
        return self::getResponse();
    }


}
