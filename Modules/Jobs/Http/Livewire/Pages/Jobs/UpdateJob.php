<?php

namespace Modules\Jobs\Http\Livewire\Jobs;

use Modules\Jobs\Models\ApplyType;
use Modules\Jobs\Models\ExperienceLevel;
use Modules\Jobs\Models\HoursPerWeek;
use Modules\Jobs\Models\Job;
use Modules\Jobs\Models\JobLength;
use Modules\Jobs\Models\PaymentType;
use Modules\Jobs\Models\ProjectSize;
use Modules\Jobs\Models\Tag;
use Modules\Jobs\Support\Livewire\WithNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateJob extends Component
{
    use WithNotification;

    public Job $job;

    public $selected_tags;

    protected $rules = [
        'job.title'        => 'required|max:254',
        'job.description'  => 'required|min:50',
        'job.apply_type'   => 'required|in:link,email',
        'job.apply_value'  => 'required',
        'job.payment_type' => 'required|in:hourly,fixed',
        'job.budget'       => 'required|numeric|min:0',
        'job.location'     => 'required|max:254',
        'selected_tags'    => 'required',
        'job.hours_per_week_id' => 'required',
        'job.experience_level_id'   => 'required',
        'job.job_length_id' => 'required',
        'job.is_active'        => 'boolean',
    ];

    public function mount(Job $job)
    {
        // Cannot access job of another user or company.
        if ($job->user_id !== Auth::id() || $job->team_id !== Auth::user()->currentTeam->id) {
            abort(403);
        }

        $this->job = $job;
        $this->selected_tags = $job->tags->pluck('id')->all();
    }

    /**
     * Update a job.
     */
    public function save()
    {
        $this->validate();

        $this->job->save();

        $this->job->tags()->sync($this->selected_tags);

        $this->success('Update the job successfully!');
    }

    public function render()
    {
        return view('livewire.jobs.update-job', [
            'companies'    => Auth::user()->allTeams(),
            'applyTypes'   => ApplyType::pluck('name', 'code'),
            'paymentTypes' => PaymentType::pluck('name', 'code'),
            'tags'         => Tag::pluck('name', 'id'),
            'jobLengths'   => JobLength::all(),
            'hoursPerWeek' => HoursPerWeek::pluck('value', 'id'),
            'experienceLevels' => ExperienceLevel::all(),
            'projectSizes' => ProjectSize::orderBy('order')->get()->toArray(),
        ]);
    }
}
