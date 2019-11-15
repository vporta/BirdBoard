
        
<div class="bg-white p-5 rounded-lg shadow">
  
  <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-light l-4">

    <a href="{{$project->path()}}" class="text-black no-underline">{{$project->title}}</a>
  </h3>

  <div class="text-grey"> {{\Illuminate\Support\Str::limit($project->description, 300)}}</div>
</div>
