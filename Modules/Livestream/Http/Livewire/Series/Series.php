<?php

namespace Modules\Livestream\Http\Livewire\Series;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;

/**
 * @property LivestreamAccount $livestreamAccount
 */
class Series extends Component
{
    use WithLivestreamAccount;

    public bool $createSeriesModalOpen = false;

    public ?string $name = null;

    public function createSeries()
    {
        $validated = $this->validate();

        $series = $this->livestreamAccount->series()->create($validated);

        $this->redirectRoute('series.update', $series);
    }

    public function getRowsQueryProperty()
    {
        return $this->livestreamAccount
            ->series()
            ->latest()
            ->withCount('episodes');
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(25);
    }

    public function render()
    {
        return view('series.series', [
            'series' => $this->rows,
        ]);
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:254',
                Rule::unique('series')->where(function ($query) {
                    return $query->where('livestream_account_id', $this->livestreamAccount->id);
                }),
            ],
        ];
    }
}
