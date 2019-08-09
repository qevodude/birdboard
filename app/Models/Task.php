<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

	protected $guarded = [];


	// updates parent records
	protected $touches = ['project'];


	public function project() 
	{

		return $this->belongsTo(Project::class);

	}

	public function path() 
	{

		return "/projects/{$this->project->id}/tasks/{$this->id}";
		
	}
	
}

