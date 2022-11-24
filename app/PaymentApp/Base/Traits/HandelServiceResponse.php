<?php

namespace PaymentApp\Base\Traits;

use Illuminate\Http\Response;

trait HandelServiceResponse
{

    public function getServiceResponse($service,mixed $data = null)
    {
        if ($service->hasErrors()) {
            $this->responseBuilder->setMessage($service->getErrors()[0]);
            $this->responseBuilder->setErrors($service->getErrors());
            $this->responseBuilder->setStatusCode(Response::HTTP_BAD_REQUEST);
        }else{
            $this->responseBuilder->setData($data);
            $this->responseBuilder->setStatusCode(Response::HTTP_ACCEPTED);
        }

        return $this->responseBuilder->getResponse();
    }
}
