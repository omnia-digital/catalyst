@php use Modules\Jobs\Enums\JobAddons; @endphp
@props([
'job'
])

@if ($job->hasAddon(JobAddons::SHOW_COMPANY_LOGO))
    <img class="w-16 h-16 rounded-full flex-shrink-0" src="{{ $job->company->logoUrl }}"
         alt="{{ $job->company->name }}">
@else
    <x-jobs::icons.default-logo class="w-16 h-16 rounded-full flex-shrink-0"/>
@endif
