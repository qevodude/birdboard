@csrf

<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="title">Title</label>
    <div class="control">
        <input
            type="text"
            class="input bg-transparent border border-gray-600 rounded p-2 text-xs w-full"
            name="title"
            placeholder="Title"
            value="{{ $project->title }}"
            required
        >
    </div>
</div>
<div class="field" mb-6>
    <label class="label text-sm mb-2 block" for="description">Description</label>
    <div class="control">
        <textarea
            name="description"
            class="textarea bg-transparent border border-gray-600 rounded p-2 text-xs w-full"
            required>
            {{ $project->description }}
        </textarea>
    </div>
</div>
<div class="field" mb-6 w-full>
    <div class="control">
        <button type="submit" class="button btn-blue">{{ $buttonText }}</button>
        <a href="{{ $project->path() }}">
            <button class="button btn-red">Cancel</button>
        </a>
    </div>
</div>


@if($errors->any())
    <div class="field mt-6 text-red-600">

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </div>

@endif

