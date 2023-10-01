<?php

namespace Modules\Livestream\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;
use Modules\Livestream\Models\Team;

class EpisodeTeam extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  Builder  $query
     * @param  mixed  $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query
            ->select('livestream_episodes.*')
            ->join('livestream_accounts', 'livestream_accounts.id', 'livestream_episodes.livestream_account_id')
            ->where('livestream_accounts.team_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @return array
     */
    public function options(Request $request)
    {
        return Team::select('id', 'name')->pluck('id', 'name')->toArray();
    }
}
