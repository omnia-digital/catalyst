<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-primary border border-gray-300 rounded-md font-semibold text-xs text-dark-text-color uppercase tracking-widest shadow-sm hover:text-base-text-color focus:outline-none focus:border-secondary focus:ring focus:ring-secondary-light active:text-dark-text-color active:bg-gray-50 disabled:opacity-25 transition']) }}>
    {{ $slot }}
</button>
