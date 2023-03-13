@extends('jobs::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="mb-3 rounded-b-lg pl-4 flex items-center bg-primary">
        <div class="mr-4 hover:bg-neutral-dark p-2 rounded-full bg-secondary hover:text-secondary">
            <a href="{{ route('jobs.my-jobs') }}">
                <x-heroicon-o-arrow-left class="h-6"/>
            </a>
        </div>
        <a href="{{route('jobs.home')}}">
            <x-library::heading.1 class="py-4 hover:cursor-pointer">{{ Trans::get('Update Job') }}</x-library::heading.1>
        </a>
    </div>
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        {{--    <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">--}}
        {{--        <nav class="space-y-1 bg-white rounded-lg shadow p-4 min-h-screen">--}}
        {{--            <h2 class="text-xl mt-2">Advertising</h2>--}}
        {{--        </nav>--}}
        {{--    </aside>--}}

        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
            <form wire:submit.prevent="save" action="#" method="POST">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                        <div>
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
                                {{ $job->title }}
                            </h2>
                            <p class="mt-1 text-sm leading-5 text-gray-500">This information will be displayed publicly so be careful what you share.</p>
                        </div>

                        <div class="grid grid-cols-3 gap-6">
                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-library::input.label for="title" value="Project Title"/>
                                <x-library::input.text wire:model.defer="job.title" id="title" placeholder="Project Title"/>
                                <x-library::input.error for="job.title"/>
                            </div>

                            <div class="col-span-3 space-y-1">
                                <x-library::input.label value="Description"/>
                                <x-library::input.textarea wire:model="job.description" id="description" placeholder="Description"/>
                                <x-library::input.error for="job.description"/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-library::input.label value="Location"/>
                                <x-library::input.text wire:model.defer="job.location" id="location" placeholder="Location"/>
                                <x-library::input.error for="job.location"/>
                                <x-library::input.help value='Example: "Remote", "Remote, USA Only", "New York City"'/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-library::input.label value="Skills"/>
                                <x-library::input.selects
                                        wire:model.defer="selected_skills"
                                        :default="$job->skills"
                                        :options="$jobPositionSkillOptions"
                                        max="5" id="selected_skills"
                                        placeholder="Type for searching a skill."/>
                                <x-library::input.error for="selected_skills"/>
                                <x-library::input.help value="Maximum is 5 skills."/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-library::input.label value="Apply Type"/>
                                <x-library::input.select wire:model.defer="job.apply_type" :options="$applyTypes" id="apply-type"/>
                                <x-library::input.error for="job.apply_type"/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-library::input.label value="Apply Value"/>
                                <x-library::input.text wire:model.defer="job.apply_value" id="apply-value" placeholder="Apply Value"/>
                                <x-library::input.error for="job.apply_value"/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-library::input.label value="Hours needed per week"/>
                                <x-library::input.select wire:model.defer="job.hours_per_week_id" :options="$hoursPerWeek" id="hours-per-week-id" placeholder="Hours needed per week"/>
                                <x-library::input.error for="job.hours_per_week_id"/>
                            </div>

                            <div class="col-span-3 space-y-1  sm:col-span-2">
                                <x-library::input.label value="Payment Type"/>
                                <x-library::input.select wire:model.defer="job.payment_type" :options="$paymentTypes" id="payment-type"/>
                                <x-library::input.error for="job.payment_type"/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-library::input.label value="Budget"/>
                                <x-library::input.text wire:model.defer="job.budget" id="budget" placeholder="Budget">
                                    <x-slot name="icon">
                                        <x-heroicon-o-currency-dollar class="h-5 w-5 text-gray-400"/>
                                    </x-slot>
                                </x-library::input.text>
                                <x-library::input.error for="job.budget"/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <div>
                                    <h2 class="text-lg leading-6 font-medium text-gray-900">How long will your work take?</h2>
                                </div>
                                @foreach ($jobLengths as $key => $jobLength)
                                    <div class="flex pt-4">
                                        <x-jobs::input.radio wire:model.defer="job.job_length_id" name="job.job_length_id" id="{{ $jobLength['title'] }}" value="{{ $jobLength['id'] }}"/>
                                        <x-library::input.label class="pl-4 font-bold" value="{{ $jobLength['description'] }}"/>
                                        <x-library::input.error for="{{ $jobLength['title'] }}"/>
                                    </div>
                                @endforeach
                                <div>
                                    <h2 class="text-lg leading-6 font-medium text-gray-900">What level of experience will it need?</h2>
                                    <p class="mt-1 text-sm leading-5 text-gray-500">This won't restrict any proposals, but helps match expertise to your budget.</p>
                                </div>
                                @foreach ($experienceLevels as $key => $experience)
                                    <div class="flex pt-4">
                                        <x-jobs::input.radio wire:model.defer="job.experience_level_id" name="job.experience_level_id" id="{{ $experience['title'] }}" value="{{ $experience['id'] }}"/>
                                        <x-library::input.label class="pl-4 font-bold" value="{{ $experience['title'] }}"/>
                                        <x-library::input.error for="{{ $experience['title'] }}"/>
                                    </div>
                                    <div class="pl-8 pt-1">
                                        <p class="mt-1 text-sm leading-5 text-gray-500">{{ $experience['description'] }}</p>
                                    </div>
                                @endforeach
                                @foreach ($projectSizes as $key => $project)
                                    <div class="flex pt-4">
                                        <x-jobs::input.radio wire:model.defer="job.project_size_id" name="project_size_id" id="{{ $project['title'] }}" value="{{ $project['id'] }}"/>
                                        <x-library::input.label class="pl-4 font-bold" value="{{ $project['title'] }}"/>
                                    </div>
                                    <div class="pl-8 pt-1">
                                        <p class="mt-1 text-sm leading-5 text-gray-500">{{ $project['description'] }}</p>
                                    </div>

                                @endforeach
                                <x-library::input.error for="job.project_size_id"/>
                                <x-library::input.label value="Active"/>
                                <x-library::input.toggle wire:model.defer="job.is_active" id="is-active"/>
                                <x-library::input.error for="job.is_active"/>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <span class="inline-flex rounded-md shadow-sm">
                        <x-library::button.link href="{{ route('jobs.job.show', ['team' => $job->company->id, 'job' => $job]) }}" target="_blank">{{ \Trans::get('Preview Job') }}</x-library::button.link>
                    </span>
                        <span class="inline-flex rounded-md shadow-sm">
                        <x-library::button>{{ \Trans::get('Save') }}</x-library::button>
                    </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
