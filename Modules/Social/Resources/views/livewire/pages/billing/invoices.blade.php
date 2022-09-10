<div>
    <x-library::heading.2 class="mb-4">Invoices</x-library::heading.2>

    <div class="align-middle min-w-full overflow-x-auto shadow overflow-hidden sm:rounded-lg">
        <x-library::table>
            <x-slot:head>
                <thead>
                <x-library::table.row>
                    <x-library::table.head class="text-left ">Amount</x-library::table.head>
                    <x-library::table.head class="text-left ">Status</x-library::table.head>
                    <x-library::table.head class="text-left ">Date</x-library::table.head>
                    <x-library::table.head class="text-right "></x-library::table.head>
                </x-library::table.row>
                </thead>
            </x-slot:head>

            <x-slot:body>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($invoices as $invoice)
                    <x-library::table.row class="{{ $loop->index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                        <x-library::table.cell class="text-left">
                            <span class="text-gray-900 font-medium">{{ $invoice->total() }}</span>
                        </x-library::table.cell>
                        <x-library::table.cell class="text-left">
                            @if ($invoice->paid)
                                <x-library::tag bg-color="success">{{ $invoice->status }}</x-library::tag>
                            @else
                                <x-library::tag bg-color="danger">{{ $invoice->status }}</x-library::tag>
                            @endif
                        </x-library::table.cell>
                        <x-library::table.cell class="text-left">
                            {{ $invoice->date()->format('Y-m-d') }}
                        </x-library::table.cell>
                        <x-library::table.cell class="text-right">
                            <a href="{{ $invoice->hosted_invoice_url }}" target="_blank" class="group inline-flex space-x-2 truncate text-sm underline hover:text-gray-600">
                                View Invoice
                            </a>
                        </x-library::table.cell>
                    </x-library::table.row>
                @empty
                    <x-library::empty>No invoices issued yet.</x-library::empty>
                @endforelse
                </tbody>
            </x-slot:body>
        </x-library::table>
    </div>
</div>
