@extends('social::livewire.layouts.main-layout')


@section('content')
<div class="-mx-4">
    <div class="h-60 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat"></div>
    <livewire:social::components.project-navigation :project="$project" />
</div>
<div class="flex space-x-6 -mx-4">
    <div class="divide-y">
        <div class="lg:grid lg:grid-cols-3 lg:gap-4">
            <div class="col-span-2">
                <div class="h-60 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat"></div>
            </div>
            <div class="col-span-1 bg-white">
                <div class="h-44 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat"></div>
                <div class="p-2">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa tempora fugiat explicabo animi omnis consectetur dolores non voluptates soluta adipisci nisi optio, dolorem distinctio debitis ipsam laudantium excepturi facere veritatis!</p>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
