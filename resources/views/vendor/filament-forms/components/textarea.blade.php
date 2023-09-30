@php
    use Filament\Support\Facades\FilamentAsset;$isConcealed = $isConcealed();
    $rows = $getRows();
    $statePath = $getStatePath();

    $initialHeight = (($rows ?? 2) * 1.5) + 0.75;
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <textarea
            @if ($shouldAutosize())
                ax-load
            ax-load-src="{{ FilamentAsset::getAlpineComponentSrc('textarea', 'filament/forms') }}"
            x-data="textareaFormComponent({ initialHeight: @js($initialHeight) })"
            x-ignore
            x-on:input="render()"
            style="height: {{ $initialHeight }}rem"
            {{ $getExtraAlpineAttributeBag() }}
            @endif
            {{
                $attributes
                    ->merge([
                        'autocomplete' => $getAutocomplete(),
                        'autofocus' => $isAutofocused(),
                        'cols' => $getCols(),
                        'disabled' => $isDisabled(),
                        'id' => $getId(),
                        'maxlength' => (! $isConcealed) ? $getMaxLength() : null,
                        'minlength' => (! $isConcealed) ? $getMinLength() : null,
                        'placeholder' => $getPlaceholder(),
                        'readonly' => $isReadOnly(),
                        'required' => $isRequired() && (! $isConcealed),
                        'rows' => $rows,
                        $applyStateBindingModifiers('wire:model') => $statePath,
                    ], escape: false)
                    ->merge($getExtraAttributes(), escape: false)
                    ->merge($getExtraInputAttributes(), escape: false)
                    ->class([
                        'fi-fo-textarea block w-full rounded-lg border-none bg-white px-3 py-1.5 text-base text-gray-950 shadow-sm outline-none ring-1 transition duration-75 placeholder:text-gray-400 focus:ring-2 disabled:bg-gray-50 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] sm:text-sm sm:leading-6',
                        'ring-gray-950/10 focus:ring-primary-600' => ! $errors->has($statePath),
                        'ring-danger-600 focus:ring-danger-600' => $errors->has($statePath),
                    ])
            }}
    ></textarea>
</x-dynamic-component>
