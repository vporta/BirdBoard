<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;
use App\Project;

class TaskTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function a_task_belongs_to_a_project()
    {

        $task = factory(Task::class)->create();

        $this->assertInstanceOf(Project::class, $task->project);

    }


    /** @test */
    public function it_has_a_path()
    {

        $task = factory(Task::class)->create();


        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }
}
