<div class="card mt-10">
    <div class="card" style="height: 200px;">

	    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-400 pl-4">
		    <a href="{{ $project->path() }} ">{{ str_limit($project->title, 20) }}</a>
	    </h3>

	    <div class="text-gray-600">{{ str_limit($project->description, 100) }}</div>

    </div>
</div>

