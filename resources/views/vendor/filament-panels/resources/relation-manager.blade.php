@php use Filament\Support\Facades\FilamentView; @endphp
<div class="fi-resource-relation-manager">
    {{ FilamentView::renderHook('panels::resource.relation-manager.before', scopes: $this->getRenderHookScopes()) }}

    {{ $this->table }}

    {{ FilamentView::renderHook('panels::resource.relation-manager.after', scopes: $this->getRenderHookScopes()) }}
</div>
