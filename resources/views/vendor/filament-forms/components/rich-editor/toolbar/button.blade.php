<button
        {{
            $attributes
                ->merge([
                    'type' => 'button',
                ], escape: false)
                ->class(['fi-fo-rich-editor-toolbar-btn flex h-8 min-w-[theme(spacing.8)] cursor-pointer items-center justify-center rounded-lg px-2 text-sm font-semibold text-gray-700 transition duration-75 hover:bg-gray-50 focus:bg-gray-50 [&.trix-active]:bg-gray-50 [&.trix-active]:text-primary-600'])
        }}
>
    {{ $slot }}
</button>
