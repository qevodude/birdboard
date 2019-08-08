<?php

namespace App\Http\Controllers;

use App\Models\Project;


class ProjectsController extends Controller
{

	public function index() {

		$projects = auth()->user()->projects;

		return view('projects.index', compact('projects'));

	}

	public function show(Project $project) {

		//$project = Project::findOrFail(request('project'));

		//if (auth()->id() != $project->owner_id) {
		if (auth()->user()->isNot($project->owner)) {
			abort(403);
		}

		return view('projects.show', compact('project'));
		
	}


	public function create() {

		return view('projects.create');
	}

	public function store() {

		//validate
		$attributes = request()->validate([
			'title' => 'required', 
			'description' => 'required'
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
