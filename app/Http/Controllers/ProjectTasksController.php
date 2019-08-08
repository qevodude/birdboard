<?php

namespace App\Http\Controllers;

use App\Models\Project;

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

}
