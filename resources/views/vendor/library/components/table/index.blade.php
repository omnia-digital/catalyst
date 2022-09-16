@props([
    'head',
    'body'
])

<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    @if (isset($head))
                        <thead {{ $head->attributes->class(['bg-gray-50']) }}>
                            {{ $head }}
                        </thead>
                    @endif

                    <tbody {{ $body->attributes->class(['bg-neutral divide-y divide-gray-200']) }}>
                        {{ $body }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
