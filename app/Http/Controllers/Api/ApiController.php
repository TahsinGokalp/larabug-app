<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\HandleExceptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected function __construct(protected HandleExceptionService $handleExceptionService){}

    public function log(Request $request): JsonResponse
    {
        return $this->handleExceptionService->start($request);
    }
}
