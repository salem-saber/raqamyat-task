<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PaymentApp\Base\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

class ApiMiddleware
{
    protected ResponseBuilder $responseBuilder;

    /**
     * @param ResponseBuilder $responseBuilder
     */
    public function __construct(ResponseBuilder $responseBuilder)
    {
        $this->responseBuilder = $responseBuilder;
    }


    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     */
    public function handle(Request $request, Closure $next)
    {
        $api_key = $request->header('x-api-key');
        if (!$api_key) {
            $this->responseBuilder->setMessage(__('auth.api_key_missing'));
            $this->responseBuilder->setErrors([__('auth.api_key_missing')]);
            $this->responseBuilder->setStatusCode(Response::HTTP_UNAUTHORIZED);

            return $this->responseBuilder->getResponse();
        }
        if ($api_key != env('API_KEY')) {
            $this->responseBuilder->setMessage(__('auth.api_key_invalid'));
            $this->responseBuilder->setErrors([__('auth.api_key_invalid')]);
            $this->responseBuilder->setStatusCode(Response::HTTP_UNAUTHORIZED);

            return $this->responseBuilder->getResponse();
        }

        return $next($request);
    }
}

