<?php

namespace App\Services\Api;

use App\Enums\ExceptionStatusEnum;
use App\Jobs\ProcessException;
use App\Models\Project;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use TahsinGokalp\LettConstants\Enum\ApiResponseCodeEnum;

class HandleExceptionService
{
    private Project $project;

    public function isException(Request $request): bool
    {
        return Arr::get($request->input('exception'), 'exception');
    }

    public function setProject($key): void
    {
        $this->project = Project::where('key', $key)->firstOrFail();
    }

    public function start(Request $request): JsonResponse
    {
        $this->setProject($request->input('project'));

        if (! $this->isException($request)) {
            return response()->json([
                'message' => trans('lett-constants::' . ApiResponseCodeEnum::ParametersValidationError->name),
                'code' => ApiResponseCodeEnum::ParametersValidationError->value,
            ]);
        }

        $exception = $this->generateExceptionAsArray($request);

        if ($this->isSnoozed($exception)) {
            return response()->json([
                'message' => trans('lett-constants::' . ApiResponseCodeEnum::ExceptionSnoozed->name),
                'code' => ApiResponseCodeEnum::ExceptionSnoozed->value,
            ]);
        }

        if ($this->isQueueEnabled()) {
            ProcessException::dispatch($exception, $this->project, now());
        } else {
            $this->handle($exception, $this->project, now());
        }

        return response()->json([
            'message' => trans('lett-constants::' . ApiResponseCodeEnum::Success->name),
            'code' => ApiResponseCodeEnum::Success->value,
        ]);
    }

    public function handle($exception, $project, $date): void
    {
        try {
            $exception = $project->exceptions()->create($exception);

            $exception->created_at = $date;
            $exception->save();

            $issue = $project->issues()
                ->firstOrCreate([
                    'exception' => $exception['exception'],
                    'line' => $exception['line'],
                ], [
                    'exception_id' => $exception->id,
                ]);

            $issue->update([
                'last_occurred_at' => $date,
                'status' => ExceptionStatusEnum::Open,
            ]);

            $exception->issue()->associate($issue)->save();

            $project->last_error_at = $date;
            $project->total_exceptions++;
            $project->save();
        } catch (Exception $exception) {
            Log::critical($exception->getMessage(), [$exception]);
        }

        $this->deleteOldExceptions($project);
    }

    private function isQueueEnabled(): bool
    {
        return (bool) config('project.queue_enabled');
    }

    private function isSnoozed(array $exception): bool
    {
        return $this->project->exceptions()->where(function ($query) use ($exception) {
            return $query
                ->where('exception', $exception['exception'])
                ->where('line', $exception['line'])
                ->whereNotNull('snooze_until')
                ->where('snooze_until', '>', now());
        })->exists();
    }

    private function generateExceptionAsArray(Request $request): array
    {
        return [
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
        ];
    }

    private function deleteOldExceptions(Project $project): void
    {
        if ($project->exceptions()->count(['id']) > config('project.max_allowed_exception')) {
            $project->exceptions()
                ->orderBy('created_at')
                ->limit(1000)
                ->delete();
        }
    }
}
