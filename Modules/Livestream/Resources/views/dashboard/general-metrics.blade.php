@php use App\Omnia; @endphp
<div>
    <h2 class="text-xl font-medium text-gray-900">Audience Analytics</h2>
    <x-metric-filter/>
    <dl class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-3">
        <x-metric-card name="Total Attachment Downloads"
                       :value="Omnia::shortenLongNumber($totalAttachmentDownloads)"/>
        <x-metric-card name="Total Episode Views" :value="Omnia::shortenLongNumber($totalEpisodeViews)"/>
        <x-model-metric-card name="Episode With Most Attachment Downloads"
                             :modelTitle="$episodeWithMostAttachmentDownloads?->title" :modelLink="$episodeWithMostAttachmentDownloads?->id ? route
        ('episodes.show',
        $episodeWithMostAttachmentDownloads?->id) : ''"/>
        <x-model-metric-card name="Most Viewed Series" :modelTitle="$mostCombinedEpisodeViews?->name"/>
    </dl>
</div>
