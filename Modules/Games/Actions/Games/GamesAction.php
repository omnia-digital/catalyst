<?php

namespace Modules\Games\Actions\Games;

use Carbon\Carbon;
use Modules\Games\Models\Game;
use Modules\Games\Models\IGDB\Game as IGDBGame;

class GamesAction
{
    public function search($search = '')
    {
        $igdbGames = IGDBGame::search($search)->limit(15)->get();
//        $igdbGames = IGDBGame::where('name', 'like', '%' . $search . '%')
//                                 ->limit(15)
//                                 ->get();
        $igdbGames = IGDBGame::fuzzySearch(
            // fields to search in
            [
                'name',
                //                'involved_companies.company.name', // you can search for nested values as well
            ],
            // the query to search for
            $search,
            // enable/disable case sensitivity (disabled by default)
            false,
        )->get();
        $games = $this->syncIgdbGames($igdbGames);

        return $games;
    }

    public function syncIgdbGames($igdbGames)
    {
        return $igdbGames->map(function ($game) {
            return Game::firstOrCreate([
                'igdb_id' => $game['id'],
            ], [
                'igdb_id' => $game['id'],
                'name' => $game['name'],
                'slug' => $game['slug'],
            ]);
        });
    }

    public function newlyReleased()
    {
        $igdbGames = IGDBGame::where('first_release_date', '>', now()->subDays(30))
            ->get();
        $games = $this->syncIgdbGames($igdbGames);

        return $games;
    }

    public function comingSoon()
    {
//        return $this->popular();
        $current = Carbon::now()->timestamp;

        $comingSoonUnformatted = IGDBGame::where('first_release_date', '>', $current)
            ->where('first_release_date', '<', $current + (60 * 60 * 24 * 7))
            ->limit(30)
            ->get();

        //        $comingSoonUnformatted = Http::withHeaders(config('services.igdb'))
        //            ->withOptions([
        //                'body' => "
        //                    fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count, summary, slug;
        //                    where platforms = (48,49,130,6)
        //                    & (first_release_date >= {$current}
        //                    & popularity > 5);
        //                    sort first_release_date asc;
        //                    limit 4;
        //                "
        //            ])->get('https://api-v3.igdb.com/games')
        //            ->json();

        $igdbGames = $comingSoonUnformatted;
        //        $igdbGames = $this->formatForView($comingSoonUnformatted);

        $games = $this->syncIgdbGames($igdbGames);

        return $games;
    }

    public function recentlyReviewed()
    {
        return $this->popular();
    }

    public function popular($limit = 10)
    {
        $igdbGames = (new GetPopularGamesAction)->execute($limit);
        $games = $this->syncIgdbGames($igdbGames);

        return $games;
    }

    public function execute($query)
    {
        // create something where we pull in games from IGDB and sync them with our database before returning the Game object from our database
        // this will allow us to only sync the games with our database that we need

        // or we could do pulls automatically from IGDB and sync them with our database on a schedule, plus the webhooks

        // the question is, where do we do the query: on IGDB or in our database?
        // and once we do the query, should we sync  it with our db?
        // what's the advantage of doing it in our db?
        // we can do joins and stuff with teams.
        // we can also create a reference to other external dbs if we need for a specific game.
        // so I think creating the game id our db is right
        // once we do a query in IGDB, we should create/update the igdb_id in our db game object
        Game::query();
    }

    // We need to call this whenever we retrieve games from igdb so we can sync them with our database and return our own Game object.

    public function query()
    {
        // allow us to pass in a custom query to igdb
    }

    public function mostAnticipated()
    {
        return $this->popular()
            ->take(5);

        $current = Carbon::now()->timestamp;
        $afterFourMonths = Carbon::now()
            ->addMonths(4)->timestamp;

        $mostAnticipatedUnformatted = Game::where('first_release_date', '>', $current)
            ->where('first_release_date', '<', $afterFourMonths)
            ->get();

        //        $mostAnticipatedUnformatted = Http::withHeaders(config('services.igdb'))
        //            ->withOptions([
        //                'body' => "
        //                    fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count, summary, slug;
        //                    where platforms = (48,49,130,6)
        //                    & (first_release_date >= {$current}
        //                    & first_release_date < {$afterFourMonths});
        //                    sort popularity desc;
        //                    limit 4;
        //                "
        //            ])->get('https://api-v3.igdb.com/games')
        //            ->json();

        //        $this->mostAnticipated = $this->formatForView($mostAnticipatedUnformatted);
        $this->mostAnticipated = $mostAnticipatedUnformatted;
    }
}
