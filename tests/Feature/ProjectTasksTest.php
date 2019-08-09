<?php

namespace Tests\Feature;

use App\Models\Project;

use Tests\TestCase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ProjectTasksTest extends TestCase
{

    use RefreshDatabase;

    /** @test */

    public function guests_cannot_add_tasks() 
    {

        $project = factory('App\Models\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }


    /** @test */
    public function only_the_project_owner_can_add_tasks ()
    {

        //$this->withoutExceptionHandling();

        $this->signInAs();

        $project = factory('App\Models\Project')->create();

        $this->post($project->path() . '/tasks' , ['body' => 'Test task'])
        ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);




    }

    /** @test */
    public function only_the_project_owner_can_update_tasks ()
    {

        //$this->withoutExceptionHandling();

        $this->signInAs();

        $project = factory('App\Models\Project')->create();

        $task = $project->addTask('test task');

        $this->patch($task->path(), ['body' => 'Changed'])
        ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed']);




    }



    /** @test */

    public function a_project_can_have_tasks() 
    {

        //$this->withoutExceptionHandling();

        $this->signInAs();

        $project = factory(Project::class)->create(['owner_id' => auth()->id() ]);
        // or
        /*
            $project = auth()->user()->projects()->create(
                factory(Project::class)->raw()
            );
        */

        $this->post($project->path() . '/tasks' , ['body' => 'Test task']);

        $this->get($project->path())

            ->assertSee('Test task');

    }

    /** @test **/

    public function a_task_can_be_updated() 
    {

        $this->withoutExceptionHandling();

        $this->signInAs();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $task = $project->addTask('test task');

        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true 
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true 
        ]);

    }
    /** @test **/

    public function a_task_requires_a_body() 
    {

        $this->signInAs();

        $project = factory(Project::class)->create(['owner_id' => auth()->id() ]);

        $attributes = factory('App\Models\Task')->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');

    }


}
