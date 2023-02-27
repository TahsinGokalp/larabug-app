<?php

namespace App\Jobs\Projects;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Browsershot\Browsershot;

class GetSiteScreenshot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $project;

    /**
     * Create a new job instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    public function handle()
    {
        try {
            Browsershot::url($this->project->url)
                ->setScreenshotType('jpeg', 25)
                ->windowSize(1280, 720)
                ->waitUntilNetworkIdle()
                ->timeout(10)
                ->save(md5($this->project->title).'.jpg');

            $this->project->clearMediaCollection('projectSiteScreenshot');

            $this->project
                ->addMedia(base_path(md5($this->project->title).'.jpg'))
                ->toMediaCollection('projectSiteScreenshot');
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
