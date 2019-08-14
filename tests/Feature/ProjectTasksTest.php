<?php

namespace Tests\Feature;

use App\Models\Project;

use Facades\Tests\Setup\ProjectFactory;
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

        $this->signInAs();

        $project = factory('App\Models\Project')->create();

        $this->post($project->path() . '/tasks' , ['body' => 'Test task'])
        ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);




    }

    /** @test */
    public function only_the_project_owner_can_update_tasks ()
    {

        $this->signInAs();

        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks->first()->path(), ['body' => 'Changed'])
        ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Changed']);




    }



    /** @test */

    public function a_project_can_have_tasks()
    {

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks' , ['body' => 'Test task']);

        $this->get($project->path())

            ->assertSee('Test task');

    }

    /** @test **/

    public function a_task_can_be_updated()
    {

        //$project= app(ProjectFactory::class)->withTasks(1)->create();
        // Or using facades...
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
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

        $project = ProjectFactory::create();

        $attributes = factory('App\Models\Task')->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');

    }


}
