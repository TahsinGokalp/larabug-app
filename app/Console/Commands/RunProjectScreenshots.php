<?php

namespace App\Console\Commands;

use App\Jobs\Projects\GetSiteScreenshot;
use App\Models\Project;
use Illuminate\Console\Command;

class RunProjectScreenshots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:screenshots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab a screenshot from the project\'s website for awesomeness.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $projects = Project::whereNotNull('url')->where('url', '!=', '')->get();

        foreach ($projects as $project) {
            dispatch(new GetSiteScreenshot($project));
        }
    }
}
