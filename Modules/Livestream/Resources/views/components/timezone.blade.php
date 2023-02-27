@props([
    'for',
    'timezone' => null,
    'format' => 'M jS, Y',
    'diffForHumans' => false
])

@php
    if (is_null($timezone)) {
         // If user not logged in, just use app timezone by default.
        if (Auth::guest()) {
            $timezone = config('app.timezone');
        }

        $timezone = Auth::user()->timezone ?? Auth::user()->currentTeam->timezone ?? config('app.timezone');
    }

    $formattedDate = \Illuminate\Support\Carbon::parse($for)->setTimezone($timezone);
@endphp

@if ($diffForHumans !== false)
    <time datetime="{{ $formattedDate->format($format) }}">{{ $formattedDate->diffForHumans() }}</time>
@else
    <time datetime="{{ $formattedDate->format($format) }}">{{$formattedDate->format($format) }}</time>
@endif
