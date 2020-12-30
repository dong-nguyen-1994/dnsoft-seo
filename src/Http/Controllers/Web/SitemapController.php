<?php

namespace Module\Seo\Http\Controllers\Web;

use Illuminate\Routing\Controller;
use Module\Seo\Models\Url;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $urls = Url::with('urlable')->get();

        return response(view('seo::sitemap', compact('urls'))->render(), 200, [
            'content-type' => 'application/xml',
        ]);
    }
}
