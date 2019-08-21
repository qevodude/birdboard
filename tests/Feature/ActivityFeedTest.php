<?php

namespace Tests\Feature;

//use phpDocumentor\Reflection\ProjectFactory;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Throwable;

class TriggerActivityTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    function creating_a_project()
    {

        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity->first()->description);


    }

    /** @test */
    function updating_a_project()
    {

        $project = ProjectFactory::create();

        $project->update(['title' => 'changed']);

        $this->assertCount(2, $project->activity);

        $this->assertEquals('updated', $project->activity->last()->description);

    }

    /** @test */
    function creating_a_new_task()
    {

        $project = ProjectFactory::create();

        $project->addTask('Some Task');

        $this->assertCount(2, $project->activity);

        $this->assertEquals('created_task', $project->activity->last()->description);

    }

    /** @test */
    function deleting_a_task()
    {

        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks->first()->delete();

        //dd($project->activity->toArray());

        $this->assertCount(3, $project->activity);

    }

    /** @test */
    function completing_a_task()
    {

        $this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);

        $this->assertEquals('completed_task', $project->activity->last()->description);

    }

    /** @test */
    function incompleting_a_task()
    {

        $this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true
            ]);
        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => false
            ]);

        //$project = $project->fresh();
        $project->refresh();

        //dd($project->fresh()->activity->toArray());

        $this->assertCount(4, $project->activity);

        $this->assertEquals('incompleted_task', $project->activity->last()->description);

    }

}
