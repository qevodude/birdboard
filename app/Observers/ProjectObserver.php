<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Project;

class ProjectObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        //$this->recordActivity('created', $project);
        $project->recordActivity('created');
    }

    /**
     * Handle the project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {

        //$this->recordActivity('updated', $project);
        $project->recordActivity('updated');

    }

    /**
     * Record activity for a project
     * @param string $type
     * @param App\Models\Project $project
     */
    //protected function recordActivity($type, $project) {
    //
        //Activity::create([
            //'project_id'=> $project->id,
            //'description' => $type
        //]);
    //}
}
