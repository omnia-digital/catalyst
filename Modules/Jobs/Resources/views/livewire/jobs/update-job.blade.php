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
                        <h2 class="text-lg leading-6 font-medium text-gray-900">Update Job</h2>
                        <p class="mt-1 text-sm leading-5 text-gray-500">This information will be displayed publicly so be careful what you share.</p>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 space-y-1 sm:col-span-2">
                            <x-input.label for="title" value="Project Title"/>
                            <x-input.text wire:model.defer="job.title" id="title" placeholder="Project Title"/>
                            <x-input.error for="job.title"/>
                        </div>

                        <div class="col-span-3 space-y-1">
                            <x-input.label value="Description"/>
                            <x-input.textarea wire:model="job.description" id="description" placeholder="Description"/>
                            <x-input.error for="job.description"/>
                        </div>

                        <div class="col-span-3 space-y-1 sm:col-span-2">
                            <x-input.label value="Location"/>
                            <x-input.text wire:model.defer="job.location" id="location" placeholder="Location"/>
                            <x-input.error for="job.location"/>
                            <x-input.help value='Example: "Remote", "Remote, USA Only", "New York City"'/>
                        </div>

                        <div class="col-span-3 space-y-1 sm:col-span-2">
                            <x-input.label value="Tags"/>
                            <x-input.selects
                                wire:model.defer="selected_tags"
                                :default="$selected_tags"
                                :options="$tags"
                                max="5" id="tags"
                                placeholder="Type for searching a tag."/>
                            <x-input.error for="selected_tags"/>
                            <x-input.help value="Maximum is 5 tags."/>
                        </div>

                        <div class="col-span-3 space-y-1 sm:col-span-2">
                            <x-input.label value="Apply Type"/>
                            <x-input.select wire:model.defer="job.apply_type" :options="$applyTypes" id="apply-type"/>
                            <x-input.error for="job.apply_type"/>
                        </div>

                        <div class="col-span-3 space-y-1 sm:col-span-2">
                            <x-input.label value="Apply Value"/>
                            <x-input.text wire:model.defer="job.apply_value" id="apply-value" placeholder="Apply Value"/>
                            <x-input.error for="job.apply_value"/>
                        </div>

                        <div class="col-span-3 space-y-1 sm:col-span-2">
                            <x-input.label value="Hours needed per week"/>
                            <x-input.select wire:model.defer="job.hours_per_week_id" :options="$hoursPerWeek" id="hours-per-week-id" placeholder="Hours needed per week"/>
                            <x-input.error for="job.hours_per_week_id"/>
                        </div>

                        <div class="col-span-3 space-y-1  sm:col-span-2">
                            <x-input.label value="Payment Type"/>
                            <x-input.select wire:model.defer="job.payment_type" :options="$paymentTypes" id="payment-type"/>
                            <x-input.error for="job.payment_type"/>
                        </div>

                        <div class="col-span-3 space-y-1 sm:col-span-2">
                            <x-input.label value="Budget"/>
                            <x-input.text wire:model.defer="job.budget" id="budget" placeholder="Budget">
                                <x-slot name="icon">
                                    <x-heroicon-o-currency-dollar class="h-5 w-5 text-gray-400"/>
                                </x-slot>
                            </x-input.text>
                            <x-input.error for="job.budget"/>
                        </div>

                        <div class="col-span-3 space-y-1 sm:col-span-2">
                            <div>
                                <h2 class="text-lg leading-6 font-medium text-gray-900">How long will your work take?</h2>
                            </div>
                            @foreach ($jobLengths as $key => $jobLength)
                                <div class="flex pt-4">
                                    <x-input.radio wire:model.defer="job.job_length_id" name="job.job_length_id" id="{{ $jobLength['title'] }}" value="{{ $jobLength['id'] }}" />
                                    <x-input.label class="pl-4 font-bold" value="{{ $jobLength['description'] }}"/>
                                    <x-input.error for="{{ $jobLength['title'] }}"/>
                                </div>
                            @endforeach
                            <div>
                                <h2 class="text-lg leading-6 font-medium text-gray-900">What level of experience will it need?</h2>
                                <p class="mt-1 text-sm leading-5 text-gray-500">This won't restrict any proposals, but helps match expertise to your budget.</p>
                            </div>
                            @foreach ($experienceLevels as $key => $experience)
                                <div class="flex pt-4">
                                    <x-input.radio wire:model.defer="job.experience_level_id" name="job.experience_level_id" id="{{ $experience['title'] }}" value="{{ $experience['id'] }}" />
                                    <x-input.label class="pl-4 font-bold" value="{{ $experience['title'] }}"/>
                                    <x-input.error for="{{ $experience['title'] }}"/>
                                </div>
                                <div class="pl-8 pt-1">
                                    <p class="mt-1 text-sm leading-5 text-gray-500">{{ $experience['description'] }}</p>
                                </div>
                            @endforeach
                            @foreach ($projectSizes as $key => $project)
                                <div class="flex pt-4">
                                    <x-input.radio wire:model.defer="job.project_size_id" name="project_size_id" id="{{ $project['title'] }}" value="{{ $project['id'] }}" />
                                    <x-input.label class="pl-4 font-bold" value="{{ $project['title'] }}"/>
                                </div>
                                <div class="pl-8 pt-1">
                                    <p class="mt-1 text-sm leading-5 text-gray-500">{{ $project['description'] }}</p>
                                </div>

                            @endforeach
                            <x-input.error for="job.project_size_id"/>
                            <x-input.label value="Active"/>
                            <x-input.toggle wire:model.defer="job.is_active" id="is-active"/>
                            <x-input.error for="job.is_active"/>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <span class="inline-flex rounded-md shadow-sm">
                        <x-form.button.link href="{{ route('jobs.show', ['team' => $job->company, 'job' => $job]) }}" target="blank" >Preview Job</x-form.button.link>
                    </span>
                    <span class="inline-flex rounded-md shadow-sm">
                        <x-form.button>Save</x-form.button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
