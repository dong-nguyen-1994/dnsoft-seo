<?php

namespace Module\Seo\Http\Controllers\Web;

use App;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Module\Seo\Models\Url;
use Module\Seo\Repositories\UrlRepositoryInterface;
use Route;

class UrlRewriteController extends Controller
{
    /**
     * @var UrlRepositoryInterface
     */
    protected $urlRepository;

    public function __construct(UrlRepositoryInterface $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }

    public function __invoke(Request $request, $path = null)
    {
        $path = ltrim(rtrim($path, '/'), '/') ?: '/';

        try {
            $urlRewrite = $this->getTargetPath($path);

            $params = $request->input();
            $params['skip'] = 'rewrite';
            //return Route::dispatchToRoute(Request::create($urlRewrite->target_path, 'GET', $params, $_COOKIE));
            $callbackFunc = $urlRewrite->controller.'@detail';

            return app()->call($callbackFunc, ['id' => $urlRewrite->urlable_id]);
        } catch (ModelNotFoundException $e) {
            if ($path === '/' && view()->exists(config('core.homepage'))) {
                return view(config('core.homepage'));
            }
        }

        return abort(404);
    }

    protected function getTargetPath($path): string
    {
        $matchRequestPath = $this->urlRepository->whereMathRequestPath($path);

        /** @var Url $urlRewrite */
        $urlRewrite = $matchRequestPath->where('locale', App::getLocale())->first();

        if (!$urlRewrite) {
            $urlRewrite = $matchRequestPath->first();
        }

        if (!$urlRewrite) {
            throw new ModelNotFoundException();
        }

        return $urlRewrite;
    }
}
