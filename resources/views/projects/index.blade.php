@extends('layouts.app')

@section('content')
  <header class="flex items-center mb-3 py-5">
    <div class="flex justify-between w-full items-end">
      <h2 class="text-gray-600 text-sm font-normal">My Projects</h2>
      
      <a href="/projects/create" class="no-underline hover:no-underline text-gray-600">New Project</a>
    </div>
  </header>


  <main class="lg:flex lg:flex-wrap -mx-3">
    @forelse($projects as $project)
      <div class="lg:w-1/3 px-3 pb-6">
        @include('projects.card')
      </div>
    @empty
      <li>No project yet</li>
    @endforelse

  </main>
  
@endsection