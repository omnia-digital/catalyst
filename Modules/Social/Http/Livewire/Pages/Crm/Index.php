<?php

namespace Modules\Social\Http\Livewire\Pages\Crm;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component implements HasTable
{
    use InteractsWithTable;

    public function render()
    {
        return view('social::livewire.pages.crm.index');
    }

    protected function getTableQuery()
    {
        return User::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name'),
        ];
    }

    public function isTableSearchable(): bool
    {
        return true;
    }
}
