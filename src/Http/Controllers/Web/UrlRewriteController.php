<?php

namespace Module\Seo\Http\Controllers\Web;

use App;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Module\Seo\Models\Url;
use Module\Seo\Repositories\ErrorRedirectRepositoryInterface;
use Module\Seo\Repositories\PreRedirectRepositoryInterface;
use Module\Seo\Repositories\UrlRepositoryInterface;
use Route;

class UrlRewriteController extends Controller
{
    /**
     * @var UrlRepositoryInterface
     */
    protected $urlRepository;

    /**
     * @var PreRedirectRepositoryInterface
     */
    protected $preRedirectRepository;

    /**
     * @var ErrorRedirectRepositoryInterface
     */
    protected $errorRedirectRepository;

    public function __construct(UrlRepositoryInterface $urlRepository, PreRedirectRepositoryInterface $preRedirectRepository, ErrorRedirectRepositoryInterface $errorRedirectRepository)
    {
        $this->urlRepository = $urlRepository;
        $this->preRedirectRepository = $preRedirectRepository;
        $this->errorRedirectRepository = $errorRedirectRepository;
    }

    public function __invoke(Request $request, $path = null)
    {
        $path = ltrim(rtrim($path, '/'), '/') ?: '/';

        try {
            $preRedirect = $this->preRedirectRepository->findBy('from_path', $path);

            return redirect($preRedirect->to_url, $preRedirect->status_code);
        } catch (Exception $e) {}

        try {
            $targetPath = $this->getTargetPath($path);

            $params = $request->input();
            $params['skip'] = 'rewrite';
            return Route::dispatchToRoute(Request::create($targetPath, 'GET', $params, $_COOKIE));
        } catch (ModelNotFoundException $e) {
            if ($path === '/' && view()->exists(config('core.homepage'))) {
                return view(config('core.homepage'));
            }
        }

        try {
            $errorRedirect = $this->errorRedirectRepository->findBy('from_path', $path);

            return redirect($errorRedirect->to_url, $errorRedirect->status_code);
        } catch (Exception $e) {}

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

        return $urlRewrite->target_path;
    }
}
