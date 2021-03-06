<div class="card mt-3">

    <ul class="text-xs list-reset">

        @foreach ($project->activity as $activity)

            <li class="{{ $loop->last ? '' : 'mb-1' }}">

                @include ("projects.activity.{$activity->description}")


                <!-- the true removes 'ago' from the display.  See carbon.php for options -->
                <span class="text-gray-700">{{ $activity->created_at->diffForHumans(null, false) }}</span>

            </li>

        @endforeach

    </ul>

</div>
