<div class="row">
    <div class="col-md-12">
        @input([
            'name' => 'seometa[title]',
            'label' => __('seo::meta.title')
        ])

        @slug([
            'name' => 'seourl[request_path]',
            'label' => __('seo::meta.url'),
            'field_slug' => 'seometa[title]'
        ])

           @textarea([
            'name' => 'seometa[description]',
            'label' => __('seo::meta.description')
        ])

        @textarea([
            'name' => 'seometa[keywords]',
            'label' => __('seo::meta.keywords')
        ])
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        @input([
        'name' => 'seometa[og_title]',
        'label' => __('seo::meta.og_title')
        ])

        @textarea([
        'name' => 'seometa[og_description]',
        'label' => __('seo::meta.og_description'),
        ])

        @singleFile([
            'name' => 'seometa[og_image]',
            'label' => __('seo::meta.og_image'),
            'type' => 'image',
            'id' => 'facebook',
            'idHolder' => 'facebookHolder'
        ])

    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        @input([
            'name' => 'seometa[twitter_title]',
            'label' => __('seo::meta.twitter_title')
        ])

        @textarea([
            'name' => 'seometa[twitter_description]',
            'label' => __('seo::meta.twitter_description')
        ])

        @singleFile([
            'name' => 'seometa[twitter_image]',
            'label' => __('seo::meta.twitter_image'),
            'type' => 'image',
            'id' => 'twitter',
            'idHolder' => 'twitterHolder'
        ])
    </div>
</div>

@push('scripts')
<script src="{{ asset('vendor/seo/admin/js/seo.js') }}"></script>
@endpush
