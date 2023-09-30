<p
        data-validation-error
        {{
            $attributes->class([
                'fi-fo-field-wrp-error-message text-sm text-danger-600',
            ])
        }}
>
    {{ $slot }}
</p>
