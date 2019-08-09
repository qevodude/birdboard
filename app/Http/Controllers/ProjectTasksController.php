<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;

class ProjectTasksController extends Controller
{
    //

    public function store (Project $project)
    {

    	// prevent unauthed user from saving to DB
    	if(auth()->user()->isNot($project->owner)){
    		abort(403);
    	}

    	request()->validate(['body' => 'required']);

    	$project->addTask(request('body'));

    	return redirect($project->path());

    }

    public function update(Project $project, Task $task)
    {

        // prevent unauthed user from saving to DB
        if(auth()->user()->isNot($project->owner)){
            abort(403);
        }
        
        request()->validate(['body' => 'required']);

        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed')
        ]);

        return redirect($project->path());

    }

}
