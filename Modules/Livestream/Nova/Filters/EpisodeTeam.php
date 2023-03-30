<?php

namespace Modules\Livestream\Nova\Filters;

use Modules\Livestream\Models\Team;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return Team::select('id', 'name')->pluck('id', 'name')->toArray();
    }
}
