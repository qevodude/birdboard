<?php

namespace App\Http\Controllers;

use App\Models\Project;


class ProjectsController extends Controller
{

	public function index() {

		$projects = auth()->user()->projects;

		return view('projects.index', compact('projects'));

	}



	/**
	 * Show a single project
	 * @param Project $project
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */

	public function show(Project $project) {

		//$project = Project::findOrFail(request('project'));

		//if (auth()->id() != $project->owner_id) {
		// if (auth()->user()->isNot($project->owner)) {
			// abort(403);
		// }

		// using a policy
		$this->authorize('update', $project);

		return view('projects.show', compact('project'));

	}


	/**
	 * Create a new project
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */

	public function create() {

		return view('projects.create');
	}



	/**
	 * Updates an existing project
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */

	public function update(Project $project) {

		$this->authorize('update', $project);

        $project->update($this->validateRequest());

		return redirect($project->path());

	}


    /**
     * Displays edit form
     */
    public function edit(Project $project) {

        return view('/projects.edit', compact('project'));

    }


    /**
     * Saves a new project
	 * @return \Illuminate\Http\Response
	 */

	public function store() {

		//validate
        //$attributes['owner_id'] = auth()->id();

		//persist
		// Project::create($attributes);
		// or
		// Create a project for the authenticated user
		$project = auth()->user()->projects()->create($this->validateRequest());

		//dd($attributes);
		//dd(auth()->user());


		//redirect
		return redirect($project->path());

	}

    /**
     * @return array
     */
    protected function validateRequest()
    {
        return $attributes = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }

}
