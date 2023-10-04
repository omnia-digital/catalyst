<?php

namespace Modules\Jobs\Http\Livewire\Pages;

use OmniaDigital\CatalystCore\Facades\Catalyst;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Jobs\Models\JobPosition;
use Modules\Jobs\Traits\WithSortAndFilters;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Home extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters, WithGuestAccess;

    public $perPage = 25;
    public $loadMoreCount = 25;

    public array $sortLabels = [
        'title' => 'title',
    ];

    public string $dateColumn = 'created_at';

    public function render()
    {
        $featuredJobs = JobPosition::with(['company', 'skills', 'addons'])
            ->featured(Catalyst::getJobSetting('featured_days', 30))
            ->active()
            ->latest()
            ->when(Catalyst::getJobSetting('featured_jobs_limit'), fn ($query, $limit) => $query->take($limit))
            ->get();

        $jobs = JobPosition::with(['company', 'skills', 'addons'])
            ->whereNotIn('id', $featuredJobs->pluck('id'))
            ->active()
            ->latest()
            ->get();

        return view('jobs::livewire.pages.home', [
            'jobs' => $jobs,
            'featuredJobs' => $featuredJobs,
        ]);
    }
}
