<?php

namespace App\Services\Command;

use App\Mail\ExceptionEmail;
use App\Models\Exception;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class SendExceptionEmailService
{
    public function sendEmails(): void
    {
        $projects = $this->getEmailEnabledProjects();
        $users = $this->getEmailEnabledUsersWithProjectMapped($projects);

        foreach ($users as $user) {
            Mail::send(new ExceptionEmail($user));
        }
    }

    private function getEmailEnabledUsersWithProjectMapped($projects): Collection
    {
        return User::where('receive_email', true)->get()->map(function ($user) use ($projects) {
            return [
                'name' => $user->name,
                'email' => $user->email,
                'projects' => $projects
            ];
        });
    }

    private function getEmailEnabledProjects(): Collection
    {
        return Project::select(['id', 'title'])
            ->where('notifications_enabled', true)
            ->where('receive_email', true)
            ->whereHas('exceptions', function ($query) {
                return $query->where('mailed', false);
            })
            ->with(['exceptions' => function ($query) {
                return $query
                    ->select('id', 'exception', 'mailed', 'created_at', 'project_id')
                    ->where('mailed', false);
            }])->get()->map(function (Project $project) {
                return [
                    'id' => $project->id,
                    'title' => $project->title,
                    'exceptions' => $project->exceptions->map(function (Exception $exception) {
                        if (! $exception->mailed) {
                            $exception->markAsMailed();
                        }

                        return [
                            'id' => $exception->id,
                            'exception' => $exception->exception,
                            'project_id' => $exception->project_id,
                            'created_at' => $exception->created_at,
                        ];
                    }),
                ];
            });
    }

}
