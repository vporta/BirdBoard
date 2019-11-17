<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    
    use RefreshDatabase;


    /** @test */
    public function guests_cannot_add_tests_to_projects()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }


    /** @test */
    function only_the_owner_of_a_project_can_add_tasks()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);

    }


    /** @test */
    function only_the_owner_of_a_project_may_update_a_task()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Project')->create();

        $task = $project->addTask('test task');


        $this->patch($task->path(), ['body' => 'changed'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);

    }


    /** @test */
    public function a_project_can_have_tasks() 
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);


        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }


    /** @test */
    public function a_task_can_be_updated()
    {
         $this->withoutExceptionHandling();

         $this->signIn();

         $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

         $task = $project->addTask('test task');

         $this->patch($project->path() . '/tasks/' . $task->id, [

            'body' => 'changed',
            'completed' => true,
         ]);

         $this->assertDatabaseHas('tasks', [

            'body' => 'changed',
            'completed' => true,
         ]);
    }


    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();
        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $attributes = factory('App\Task')->raw(['body' => '']);
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');



    }

}




