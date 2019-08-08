@extends('layouts.app')

@section('content')

	<header class="flex items-center mb-3 py-3">

		<div class="flex justify-between items-center w-full">

				<p class="text-gray-600 font-normal">

					<a href="/projects" class="text-gray-600 font-normal"> My Projects </a>/ {{ $project->title }}

				</p>


			<a href="/projects/create"><button class="btn-blue">New project</button></a>

		</div>

	</header>

	<main>

		<div class="lg:flex -m-3">

			<div class="lg:w-3/4 px-3 mb-6">

				<div class="mb-8">

					<h2 class="text-lg text-gray-600 font-normal mb-3">Tasks</h2>

					@foreach ($project->tasks as $task) 

						<div class="card mb-4" >{{ $task->body }}</div>

					@endforeach

				</div>

				<div class="mb-8">
					
					<h2 class="text-lg text-gray-600 font-normal mb-3">General Notes</h2>

					<textarea class="card w-full" style="min-height: 200px">Lorem Ipsum</textarea>
				</div>

			</div>

			<div class="lg:w-1/4 px-3">

				<div class="card">

					@include('projects.card')

				</div>



			</div>

		</div>

	</main>





	<a href="/projects">Go Back</a>

@endsection