@extends('layouts.app')

@section('content')

  <form method="POST" action="/projects">
    @csrf

    <h1>Create a Project</h1>
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" placeholder="title" name="title">
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" placeholder="Description" name="description"></textarea> 
      </div>
      
      <button type="submit" class="btn btn-default">Submit</button>
      <a href="/projects">Cancel</a>
  </form>
@endsection