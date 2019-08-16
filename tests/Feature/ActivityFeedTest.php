<?php

namespace Tests\Feature;

//use phpDocumentor\Reflection\ProjectFactory;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Throwable;

class ActivityFeedTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    function creating_a_project_generates_activity()
    {

        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity->first()->description);


    }

    /** @test */
    function updating_a_project_generates_activity()
    {

        $project = ProjectFactory::create();

        $project->update(['title' => 'changed']);

        $this->assertCount(2, $project->activity);

        $this->assertEquals('updated', $project->activity->last()->description);

    }


}
