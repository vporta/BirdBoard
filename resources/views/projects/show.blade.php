@extends('layouts.app')

@section('content')

    <header class="flex items-center mb-3 py-5">
      <div class="flex justify-between w-full items-end">
        <p class="text-gray-600 text-sm font-normal">
            <a href="/projects" class="text-gray-600 text-sm font-normal">My Projects</a> / {{$project->title}}

        </p>
        
        <a href="/projects/create" class="no-underline hover:no-underline text-gray-600">New Project</a>
      </div>
    </header>


    <main>
        <div class="lg:flex px-3 -mx-3">
            
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-gray-600 text-sm font-normal mb-3">Tasks</h2>
                    
                    @foreach($project->tasks as $task)
                        <div class="bg-white p-5 rounded-lg shadow mb-6">
                            <form action="{{$task->path()}}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="flex">
                                    <input name="body" value="{{$task->body}}" class="w-full {{ $task->completed ? 'text-gray-400' : ''}}">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                                </div>
                            </form>
                        </div>
                    
                    @endforeach
                        <div class="bg-white p-5 rounded-lg shadow mb-6">
                           <form action="{{$project->path() . '/tasks'}}" method="POST">
                               @csrf
                                <input type="text" name="body" placeholder="Add a new task ..." class="w-full"> 
                           </form>

                        </div>
                </div>

                <div>
                    
                    <h2 class="text-lg text-gray-600 text-sm font-normal mb-3">General Notes</h2>

                    <form action="{{$project->path()}}" method="POST">
                        @csrf
                        @method('PATCH')

                        <textarea 
                            name="notes"
                            class="bg-white p-5 rounded-lg shadow w-full" 
                            style="min-height: 200px;" 
                            placeholder="Add notes here ...">{{$project->notes}}</textarea>

                        <button type="submit" class="button">Save</button>
                    </form>
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>



    <a href="/projects">Go Back</a>
@endsection