@extends('layouts.app')

@section('content')

	<header class="flex items-center mb-3 py-3">

		<div class="flex justify-between items-center w-full">

			<h2 class="text-gray-600 text-sm">My Projects</h2>

			<a href="/projects/create"><button class="btn-blue">New project</button></a>

		</div>

	</header>

	<main class="lg:flex lg:flex-wrap -mx-4">

		@forelse ($projects as $project)

			<div class="lg:w-1/3 px-4 py-3 pb-3">
				<div class="bg-white p-5 rounded-lg shadow" style="height: 200px;">

					<h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-400 pl-4">
						<a href="{{ $project->path() }} ">{{ str_limit($project->title, 20) }}</a>
					</h3>
			
					<div class="text-gray-600">{{ str_limit($project->description, 100) }}</div>

				</div>
			</div>
		
		@empty

			<div>No projects yet</div>

		@endforelse

	</main>

	</ul>

@endsection