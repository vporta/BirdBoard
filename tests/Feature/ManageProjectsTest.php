<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Project;
use Facades\Tests\Setup\ProjectFactory;


class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /** @test */
    public function guests_cannot_manage_projects()
    {
        // $this->withoutExceptionHandling();
        $project = factory('App\Project')->create();
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
      $this->withoutExceptionHandling();
      $this->signIn();
      // $this->actingAs(factory('App\User')->create());
      $this->get('/projects/create')->assertStatus(200);
      $attributes = [ 
        'title' => $this->faker->sentence,
        'description' => $this->faker->sentence,
        'notes' => "General notes here",
        // 'owner_id' => factory(User::class)->create()->id
      ];

      $response = $this->post('/projects', $attributes);
      $project = Project::where($attributes)->first();
      $response->assertRedirect($project->path());

      // $this->assertDatabaseHas('projects', $attributes);

      $this->get($project->path())
        ->assertSee($attributes['title'])
        ->assertSee($attributes['description'])
        ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
      // $this->signIn();
      // $this->withoutExceptionHandling();
      // $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
      $project = ProjectFactory::create();
      $this->actingAs($project->owner)
        ->patch($project->path(), ['notes' => 'Changed'])
        ->assertRedirect($project->path());
      $this->assertDatabaseHas('projects', ['notes' => 'Changed']);
    }


    /** @test */
    public function a_project_requires_a_title()
    {
      // $this->actingAs(factory('App\User')->create());
      $this->signIn();
      $attributes = factory('App\Project')->raw(['title' => '']);
      $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }


    /** @test */
    public function a_project_requires_a_description()
    {
      // $this->actingAs(factory('App\User')->create());
      $this->signIn();
      $attributes = factory('App\Project')->raw(['description' => '']);
      $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }


    /** @test */
    public function a_user_can_view_their_project()
    {
      // $this->withoutExceptionHandling();
      // $this->signIn();
      // $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

      $project = ProjectFactory::create();
      $this->actingAs($project->owner)->get($project->path())
        ->assertSee($project->title)
        ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        // $this->withoutExceptionHandling();
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->create();
        $this->patch($project->path(), [])->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        // $this->withoutExceptionHandling();
        $this->be(factory('App\User')->create());
        $project = factory('App\Project')->create();
        $this->get($project->path())->assertStatus(403);
    }
}










