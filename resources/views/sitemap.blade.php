<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($urls as $url)
    <url>
        <loc>{{ url($url->request_path) }}</loc>
        <lastmod>{{ object_get($url, 'urlable.updated_at') ?: $url->updated_at }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
@endforeach
</urlset>
