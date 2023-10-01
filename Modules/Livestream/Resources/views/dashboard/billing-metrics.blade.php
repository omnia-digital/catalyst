@php use App\Omnia; @endphp
<div>
    <h2 class="text-xl font-medium text-gray-900">Billing Metrics</h2>
    <dl class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-3">
        <x-metric-card name="Total Storage Duration" :value="Omnia::formatDuration($totalStorageDuration)"/>
        <x-metric-card name="Expired Episodes Duration" :value="Omnia::formatDuration($billableStorageDuration)"/>
        <x-metric-card name="Current Storage Cost" :value="Omnia::money($currentStorageCost)"/>
        <x-metric-card name="Total Expired Episode Count"
                       :value="Omnia::shortenLongNumber($totalExpiredEpisodeCount)"/>
    </dl>
</div>
