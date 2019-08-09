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

		$project->update(request(['notes']));

		return redirect($project->path());

	}


	/**
	 * Saves a new project
	 * @return \Illuminate\Http\Response
	 */
	
	public function store() {

		//validate
		$attributes = request()->validate([
			'title' => 'required', 
			'description' => 'required',
			'notes' => 'min:3'
		]);

		//$attributes['owner_id'] = auth()->id();

		//persist
		// Project::create($attributes);
		// or
		// Create a project for the authenticated user
		$project = auth()->user()->projects()->create($attributes);

		//dd($attributes);
		//dd(auth()->user());


		//redirect
		return redirect($project->path());

	}

}
