<div class="flex items-center">
    <span class="rounded-md shadow-sm">
        <select
            {{ $attributes->merge(['class' => 'form-select block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5']) }}
        >
            <option disabled selected>Select a company</option>

            @foreach ($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
            @endforeach
        </select>
    </span>
</div>
