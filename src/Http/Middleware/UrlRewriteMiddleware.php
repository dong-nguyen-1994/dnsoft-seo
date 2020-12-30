<?php

namespace Module\Seo\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Module\Seo\Models\Url;

class UrlRewriteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->input('skip') == 'rewrite' || $request->is(config('core.admin_prefix').'*')) {
            return $next($request);
        }

        $targetPath = ltrim(parse_url($request->path(), PHP_URL_PATH), '/');

        /** @var Url $seourl */
        $seourl = Url::where('target_path', $targetPath)->first();
        if ($seourl) {
            $toUrl = $seourl->request_path;
            if ($query = $request->query()) {
                $toUrl .= '?' . http_build_query($query);
            }

            return redirect($toUrl, 301);
        }

        return $next($request);
    }
}
