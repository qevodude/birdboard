<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

   /** @test **/

    public function guests_cannot_manage_projects() 
    {
        //$this->withoutExceptionHandling();

        $project = factory('App\Models\Project')->create();

        // cant create a project
        $this->get('/projects/create')->assertRedirect('login');

        // cant view project dashboard
        $this->get('/projects')->assertRedirect('login');

        // cant view a specific project
        $this->get($project->path())->assertRedirect('login');

        // can't store a project
        $this->post('/projects', $project->toArray())->assertRedirect('login');

    }

    /** @test **/

    public function a_user_can_create_a_project() 
    {

        $this->signInAs();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $test_title = str_limit($attributes['title'], 20);
        $test_description = str_limit($attributes['description'], 100);

        //$this->post('/projects', $attributes)->assertRedirect('/projects');

        $response = $this->post('/projects', $attributes);

        $response->assertRedirect(Project::where($attributes)->first()->path());

        //$response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($test_title, 20);
    }

    /** @test **/

    public function a_user_can_view_their_project() 
    {

        $this->signInAs();

        $project = factory('App\Models\Project')->create(['owner_id' => auth()->id()]);

        $test_title = str_limit($project->title, 20);
        $test_description = str_limit($project->description, 100);

        $this->get($project->path())
            ->assertSee($test_title)
            ->assertSee($test_description);

    }


    /** @test **/

    public function an_authenticated_user_cannot_view_projects_of_others() 
    {

        $this->signInAs();

        $project = factory('App\Models\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test **/

    public function a_project_requires_a_title() 
    {

        $this->signInAs();

        $attributes = factory('App\Models\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');

    }

    /** @test **/

    public function a_project_requires_a_description() 
    {

        $this->signInAs();

        $attributes = factory('App\Models\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');

    }

    /** @test **/

    public function a_project_belongs_to_an_owner() 
    {

        $project = factory('App\Models\Project')->create();

        $this->assertInstanceOf('App\Models\User', $project->owner);

    }

 

}
