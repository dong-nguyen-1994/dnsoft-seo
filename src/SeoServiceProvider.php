<?php

namespace Module\Seo;

use Illuminate\Support\Facades\Blade;
use DnSoft\Core\Support\BaseModuleServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Module\Seo\Events\SeoAdminMenuRegistered;
use Module\Seo\Http\Middleware\UrlRewriteMiddleware;
use Module\Seo\Models\Meta;
use Module\Seo\Models\Url;
use Module\Seo\Repositories\Eloquent\MetaRepository;
use Module\Seo\Repositories\Eloquent\UrlRepository;
use Module\Seo\Repositories\MetaRepositoryInterface;
use Module\Seo\Repositories\UrlRepositoryInterface;

class SeoServiceProvider extends BaseModuleServiceProvider
{
    public function getModuleNamespace(): string
    {
        return 'seo';
    }

    public function register()
    {
        parent::register();

        $this->app->singleton(MetaRepositoryInterface::class, function () {
            return new MetaRepository(new Meta());
        });

        $this->app->singleton(UrlRepositoryInterface::class, function () {
            return new UrlRepository(new Url());
        });
    }

    public function boot()
    {
        parent::boot();

        /** @var Router $router */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', UrlRewriteMiddleware::class);

        Blade::include('seo::admin.field', 'seo');
        Blade::include('seo::meta', 'seometa');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/seo'),
        ], 'seo');
    }
}
