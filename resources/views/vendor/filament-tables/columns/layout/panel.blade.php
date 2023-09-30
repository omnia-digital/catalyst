<div
        {{
            $attributes
                ->merge($getExtraAttributes(), escape: false)
                ->class(['rounded-lg bg-gray-50 p-4 ring-1 ring-inset ring-gray-950/5'])
        }}
>
    <x-filament-tables::columns.layout
            :components="$getComponents()"
            :record="$getRecord()"
            :record-key="$recordKey"
    />
</div>
