@extends('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:ps-16 rounded shadow w-full">

        <h1 class="text-2xl font-normal mb-10 text-center">
            Edit your project
        </h1>

        <form
            method=POST
            action="{{ $project->path() }}"
        >

            @method('PATCH')

            @include('projects._form',[
                'buttonText' => 'Update Project'
            ])

        </form>

    </div>
@endsection
