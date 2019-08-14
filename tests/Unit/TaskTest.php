<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{

	use RefreshDatabase;

	/** @test */

    public function a_task_belongs_to_a_project()
    {

    	$task = factory(Task::class)->create();
    	//dd($task->attributes);

    	$this->assertInstanceOf(Project::class, $task->project);

    }

	/** @test */

    public function a_task_has_a_path()
    {

    	$task = factory(Task::class)->create();

    	$this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());

    }
}