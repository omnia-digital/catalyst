<?php

namespace Modules\Games\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Models\Platform;
use MarcReichel\IGDBLaravel\Models\Website;
use Modules\Games\Models\Game;

class GamesController extends Controller
{


    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        return view('games::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     */
    public function show($slug): \Illuminate\View\View
    {
        $game = Game::where('slug', $slug)->firstOrFail();

        //        $game = Http::withHeaders(config('services.igdb'))
        //            ->withOptions([
        //                'body' => "
        //                    fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating,
        //                    slug, involved_companies.company.name, genres.name, aggregated_rating, summary, websites.*, videos.*, screenshots.*, similar_games.cover.url, similar_games.name, similar_games.rating,similar_games.platforms.abbreviation, similar_games.slug;
        //                    where slug=\"{$slug}\";
        //                "
        //            ])->get('https://api-v3.igdb.com/games')
        //            ->json();

        abort_if(!$game, 404);

//        return view('games::show', [
//            'game' => $this->formatGameForView($game),
//        ]);

        return view('games::show', [
            'game' => $game,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id): void
    {
        //
    }


    /**
     * @return \Illuminate\Support\Collection|null
     *
     * @psalm-return \Illuminate\Support\Collection<int, mixed>|null
     */
    private function formatGameForView($game)
    {
        if (!$game || is_int($game)) {
            return;
        }
        return collect($game)->merge([
            'coverImageUrl' => $game->cover_url,
            'genres' => collect($game['genres'])->pluck('name')->implode(', '),
            'involvedCompanies' => $game->involved_companies,
            'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            'memberRating' => array_key_exists('rating', $game->toArray()) ? round($game['rating']) : '0',
            'criticRating' => array_key_exists('aggregated_rating', $game->toArray()) ? round($game['aggregated_rating']) : '0',
            'trailer' => $game->getTrailer() ? 'https://youtube.com/embed/'.$game->trailer['video_id'] : '',
            'screenshots' => collect($game['screenshots'])->map(function ($screenshot) {
                return [
                    'big' => Str::replaceFirst('thumb', 'screenshot_big', $screenshot['url']),
                    'huge' => Str::replaceFirst('thumb', 'screenshot_huge', $screenshot['url']),
                ];
            })->take(9),
            'similarGames' => collect($game['similar_games'])->map(function ($game_id) {
                $similarGame = Game::where('id', $game_id)->firstOrFail();
                return collect($similarGame)->merge([
                    'coverImageUrl' => $similarGame?->cover_url,
                    'rating' => isset($similarGame['rating']) ? round($similarGame['rating']) : null,
                    'platforms' => array_key_exists('platforms', $similarGame->toArray())
                        ? collect($similarGame['platforms'])->pluck('abbreviation')->implode(', ')
                        : null,
                ]);
            })->take(6),
        ])->flatten();
    }
}
