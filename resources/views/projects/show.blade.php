@extends('layouts.app')

@section('content')

	<header class="flex items-center mb-3 py-3">

		<div class="flex justify-between items-center w-full">

				<p class="text-gray-600 font-normal">

					<a href="/projects" class="text-gray-600 font-normal"> My Projects </a>/ {{ $project->title }}

				</p>


			<a href="{{ $project->path() . '/edit' }}"><button class="btn-blue">Edit project</button></a>

		</div>

	</header>

	<main>

		<div class="lg:flex -m-3">

			<div class="lg:w-3/4 px-3 mb-6">

				<div class="mb-8">

					<h2 class="text-lg text-gray-600 font-normal mb-3">Tasks</h2>

						<div class="card mb-4" >

							<form action="{{ $project->path() . '/tasks' }}" method="POST">

								@csrf

								<input name="body" placeholder="Begin adding tasks..." class="w-full">

							</form>

						</div>



					@foreach ($project->tasks as $task)

						<div class="card mb-4" >

							<form action=" {{ $task->path() }}" method="POST">

								@csrf

								@method('PATCH')

								<div class="flex">

									<input class="mt-1" type="checkbox" name="completed" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }} >

									<input name="body" value=" {{ $task->body }} " class="w-full {{ $task->completed ? 'text-gray-600' : '' }} " >


								</div>

							</form>
						</div>

					@endforeach


				</div>

				<div class="mb-8">

					<h2 class="text-lg text-gray-600 font-normal mb-3">General Notes</h2>

					<form method="POST" action="{{ $project->path() }}">
						@csrf
						@method('PATCH')

						<textarea name="notes"
							class="card w-full"
							style="min-height: 200px"
							placeholder="Enter any notes here">
{{ $project->notes }}
						</textarea>

						<button type="submit" class="btn-blue">Save</button>

					</form>

                    @if($errors->any())
                        <div class="field mt-6 text-red-600">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </div>

                    @endif


				</div>

			</div>

			<div class="lg:w-1/4 px-3">

			    @include('projects.card')

                @include("projects.activity.card")

			</div>

		</div>

	</main>





	<a href="/projects">Go Back</a>

@endsection
