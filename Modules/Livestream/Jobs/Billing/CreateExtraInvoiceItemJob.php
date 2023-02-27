<?php namespace App\Jobs\Billing;

use App\Models\Episode;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateExtraInvoiceItemJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Episode $episode;

    public function __construct(public Team $team, int $episodeId)
    {
        $this->episode = Episode::withTrashed()->findOrFail($episodeId);
    }

    public function handle()
    {
        // We don't want to create extra invoice when the episode is trashed
        // It might cause the duplication.
        if ($this->episode->trashed()) {
            return;
//            throw new \ErrorException('Episode is already trashed.');
        }

        $this->team->extraInvoiceItems()->create([
            'livestream_account_id' => $this->episode->livestreamAccount->id,
            'duration'              => $this->episode->duration ?? 0,
            'amount'                => $this->calculateAmount(),
            'billing_reason'        => 'Storage fee from ' . $this->from()->toDateString() . ' to ' . $this->to()->toDateString()
        ]);
    }

    protected function calculateAmount(): float
    {
        // Duration in seconds.
        $duration = ($this->episode->duration ?? 0) / 1000;

        // Convert duration to minutes if unit type is minute.
        if (config('metered.price.unit') === 'minute') {
            $duration = $duration / 60;
        }

        return round($duration * $this->team->meteredPrice('storage'), 2);
    }

    protected function from(): Carbon
    {
        return now()->startOfMonth();
    }

    protected function to(): Carbon
    {
        return now();
    }
}
