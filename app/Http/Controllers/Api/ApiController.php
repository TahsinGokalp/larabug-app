<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\Projects\ProcessException;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ApiController extends Controller
{
    public function log(Request $request)
    {
        $project = Project::where('key', $request->input('project'))->firstOrFail();

        if (! Arr::get($request->input('exception'), 'exception')) {
            return response()->json([
                'error' => 'Did not receive the correct parameters to process this exception',
            ])->setStatusCode(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        dispatch_sync(new ProcessException([
            'id' => Str::uuid(),
            'host' => Arr::get($request->input('exception'), 'host'),
            'environment' => Arr::get($request->input('exception'), 'environment'),
            'error' => Arr::get($request->input('exception'), 'error'),
            'additional' => $request->input('additional'),
            'method' => Arr::get($request->input('exception'), 'method'),
            'class' => Arr::get($request->input('exception'), 'class'),
            'file' => Arr::get($request->input('exception'), 'file'),
            'file_type' => Arr::get($request->input('exception'), 'file_type', 'php'),
            'line' => Arr::get($request->input('exception'), 'line'),
            'fullUrl' => Arr::get($request->input('exception'), 'fullUrl'),
            'executor' => Arr::get($request->input('exception'), 'executor'),
            'storage' => Arr::get($request->input('exception'), 'storage'),
            'exception' => Str::limit(Arr::get($request->input('exception'), 'exception'), 10000),
            'user' => $request->input('user'),
            'project_version' => Arr::get($request->input('exception'), 'project_version'),
        ], $project, now()));

        return response(['OK']);
    }
}
