<?php

namespace Modules\Games\Http\Livewire\Components;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Modules\Games\Models\Game;

class SearchDropdown extends Component
{
    public $search = '';
    public $searchResults = [];

    public function render(): \Illuminate\View\View
    {
        if (strlen($this->search) >= 2) {

            $this->searchResults = Game::where('name', 'like', '%' . $this->search . '%')
                                       ->limit(8)
                                       ->get();
//            $this->searchResults =  Http::withHeaders(config('services.igdb'))
//                ->withOptions([
//                    'body' => "
//                        search \"{$this->search}\";
//                        fields name, slug, cover.url;
//                        limit 8;
//                    "
//                ])->get('https://api-v3.igdb.com/games')
//                ->json();
        }

        return view('games::livewire.components.search-dropdown');
    }
}
