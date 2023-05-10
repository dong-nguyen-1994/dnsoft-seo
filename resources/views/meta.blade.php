<meta name="description" content="{{ object_get($item, 'seometa.description', object_get($item, 'description')) }}"/>

{{--<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1"/>--}}
<link rel="canonical" href="{{ object_get($item, 'seometa.canonical', object_get($item, 'url')) }}"/>

<meta property="og:locale" content="vi_VN"/>
<meta property="og:type" content="article"/>

<meta property="og:title" content="{{ object_get($item, 'seometa.title', object_get($item, 'name')) }}"/>
<meta property="og:description" content="{{ object_get($item, 'seometa.og_description', object_get($item, 'seometa.description', object_get($item, 'description'))) }}"/>
<meta property="og:url" content="{{ object_get($item, 'url') }}"/>
<meta property="og:site_name" content="{{ get_setting_value_by_name('site_name') }}"/>

{{--<meta property="article:author" content=""/>--}}
{{--<meta property="article:tag" content="marketing"/>--}}
{{--<meta property="article:section" content="Case Study"/>--}}

@if($published_time = $item->published_at ?? $item->created_at)
    <meta property="article:published_time" content="{{ $published_time->toAtomString() }}"/>
@endif

@if($modified_time = $item->updated_at)
    <meta property="article:modified_time" content="{{ $modified_time->toAtomString() }}"/>
    <meta property="og:updated_time" content="{{ $modified_time->toAtomString() }}"/>
@endif

@if($ogImage = object_get($item, 'seometa.og_image', object_get($item, 'image')))
    <meta property="og:image" content="{{ $ogImage->getUrl() }}"/>
    {{--<meta property="og:image:secure_url" content=""/>--}}
    {{--<meta property="og:image:width" content=""/>--}}
    {{--<meta property="og:image:height" content=""/>--}}
@endif

<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:title" content="{{ object_get($item, 'seometa.twitter_title', object_get($item, 'seometa.description', object_get($item, 'description'))) }}"/>
<meta name="twitter:description" content="{{ object_get($item, 'seometa.twitter_description', object_get($item, 'seometa.description', object_get($item, 'description'))) }}"/>

@if($twitterImage = object_get($item, 'seometa.twitter_image', object_get($item, 'image')))
    <meta name="twitter:image" content="{{ $twitterImage->getUrl() }}"/>
@endif

{{--<meta name="twitter:creator" content="@dnsoft"/>--}}
{{--<script type='application/ld+json'></script>--}}
