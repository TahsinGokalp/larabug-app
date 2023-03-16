@component('mail::message')
# There have been new exceptions in the following projects.

@foreach ($collection['projects'] as $project)
## Project: {{ $project['title'] }}

@foreach ($project['exceptions'] as $exception)
**Exception:** {{ \Illuminate\Support\Str::limit($exception['exception'], 50) }}<br />
**Date:** {{ $exception['created_at'] }}<br />
<a href="{{ route('exceptions.show', [$project['id'], $exception['id']]) }}">View exception</a><br /><br />
@endforeach
@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent
