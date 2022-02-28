@props([
    'head',
    'body'
])

<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    <div class="py-2 align-middle inline-block min-w-full">
        <table class="min-w-full divide-y divide-gray-200">
            @if (isset($head))
                <thead {{ $head->attributes->class(['bg-gray-50']) }}>
                {{ $head }}
                </thead>
            @endif

            <tbody {{ $body->attributes->class(['bg-white divide-y divide-gray-200']) }}>
                {{ $body }}
            </tbody>
        </table>
    </div>
</div>
