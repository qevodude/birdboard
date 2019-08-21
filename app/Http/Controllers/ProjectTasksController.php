<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;

class ProjectTasksController extends Controller
{
    /**
     * Save a new task
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function store (Project $project)
    {

    	// prevent unauthed user from saving to DB
        $this->authorize('update', $project);
    	//if(auth()->user()->isNot($project->owner)){
    		//abort(403);
    	//}

    	request()->validate(['body' => 'required']);

    	$project->addTask(request('body'));

    	return redirect($project->path());

    }

    /**
     * Update new task
     * @param Project $project
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Project $project, Task $task)
    {


        // prevent unauthed user from saving to DB
        $this->authorize('update', $task->project);
        //if(auth()->user()->isNot($task->project->owner)){
            //abort(403);
        //}

        $attributes = request()->validate(['body' => 'required']);
        $task->update($attributes);
        request('completed') ? $task->complete() : $task->incomplete();

        //if (request('completed')) {
            //$task->complete();
        //} else {
            //$task->incomplete();
        //}

        return redirect($project->path());

    }

}

