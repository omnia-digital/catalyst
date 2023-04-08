@extends('livestream::layouts.master')

@section('content')
    <x-library::heading.1>Hello World</x-library::heading.1>

    <p>
        This view is loaded from module: {!! config('livestream.name') !!}
    </p>
@endsection
