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

			@include ('projects.card')

		</div>

		
		@empty

			<div>No projects yet</div>

		@endforelse

	</main>

	</ul>

@endsection