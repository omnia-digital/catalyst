<?php

namespace App\Http\Livewire\Series;

use App\Support\Livewire\WithNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class UpdateSeries extends Component
{
    use WithNotification, AuthorizesRequests;

    public \App\Models\Series $series;

    public bool $deleteSeriesModalOpen = false;

    protected function rules(): array
    {
        return [
            'series.name' => ['required', 'max:254']
        ];
    }

    public function mount()
    {
        $this->authorize('update', $this->series);
    }

    public function updateSeries()
    {
        $this->authorize('update', $this->series);

        $this->validate();

        $this->series->save();

        $this->success('Update series successfully!');
    }

    public function deleteSeries()
    {
        $this->authorize('delete', $this->series);

        $this->series->delete();

        $this->redirectRoute('series');
    }

    public function render()
    {
        return view('series.update-series');
    }
}
