<?php

namespace Modules\Social\Http\Livewire\Pages\Art;

use App\Models\Tag;
use App\Models\User;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Modules\Social\Models\Post;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Index extends Component
{
    public function getMediaItemsProperty()
    {
//        $media = Media::all();
//        $postImages = Post::whereNotNull('image')->get('image');

//        return $media->merge($postImages);

        return Post::withAnyTags(['art'])->get();
    }

    public function render()
    {
        return view('social::livewire.pages.art.index', [
            'media_items' => $this->media_items,
        ]);
    }
}
