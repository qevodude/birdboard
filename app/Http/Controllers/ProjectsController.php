<?php

namespace App\Http\Controllers;

use App\Project;


class ProjectsController extends Controller
{

	public function index() {

		$projects = Project::all();

		return view('projects.index', compact('projects'));

	}

	public function show(Project $project) {

		//$project = Project::findOrFail(request('project'));

		return view('projects.show', compact('project'));
		
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
		auth()->user()->projects()->create($attributes);

		//dd($attributes);
		//dd(auth()->user());


		//redirect
		return redirect('/projects');

	}

}
