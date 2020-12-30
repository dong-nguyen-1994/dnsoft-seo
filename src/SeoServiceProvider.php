<?php

namespace Module\Seo;

use Illuminate\Support\Facades\Blade;
use Dnsoft\Core\Support\BaseModuleServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Module\Seo\Events\SeoAdminMenuRegistered;
use Module\Seo\Models\ErrorRedirect;
use Module\Seo\Models\PreRedirect;
use Module\Seo\Repositories\Eloquent\ErrorRedirectRepository;
use Module\Seo\Repositories\Eloquent\PreRedirectRepository;
use Module\Seo\Repositories\ErrorRedirectRepositoryInterface;
use Module\Seo\Repositories\PreRedirectRepositoryInterface;
use Module\Seo\Http\Middleware\UrlRewriteMiddleware;
use Module\Seo\Models\Meta;
use Module\Seo\Models\Url;
use Module\Seo\Repositories\Eloquent\MetaRepository;
use Module\Seo\Repositories\Eloquent\UrlRepository;
use Module\Seo\Repositories\MetaRepositoryInterface;
use Module\Seo\Repositories\UrlRepositoryInterface;
use Dnsoft\Acl\Facades\Permission;
use Dnsoft\Core\Events\CoreAdminMenuRegistered;

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

        $this->app->singleton(PreRedirectRepositoryInterface::class, function () {
            return new PreRedirectRepository(new PreRedirect());
        });

        $this->app->singleton(ErrorRedirectRepositoryInterface::class, function () {
            return new ErrorRedirectRepository(new ErrorRedirect());
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

        $this->registerAdminMenu();
        $this->registerPermissions();
    }

    public function registerPermissions()
    {
        Permission::add('seo.admin.seo.edit', __('seo::permission.seo.edit'));

        Permission::add('seo.admin.pre-redirect', __('seo::permission.pre-redirect.header'));
        Permission::add('seo.admin.pre-redirect.index', __('seo::permission.pre-redirect.index'));
        Permission::add('seo.admin.pre-redirect.create', __('seo::permission.pre-redirect.create'));
        Permission::add('seo.admin.pre-redirect.edit', __('seo::permission.pre-redirect.edit'));
        Permission::add('seo.admin.pre-redirect.destroy', __('seo::permission.pre-redirect.destroy'));

        Permission::add('seo.admin.error-redirect', __('seo::permission.error-redirect.header'));
        Permission::add('seo.admin.error-redirect.index', __('seo::permission.error-redirect.index'));
        Permission::add('seo.admin.error-redirect.create', __('seo::permission.error-redirect.create'));
        Permission::add('seo.admin.error-redirect.edit', __('seo::permission.error-redirect.edit'));
        Permission::add('seo.admin.error-redirect.destroy', __('seo::permission.error-redirect.destroy'));
    }

    public function registerAdminMenu()
    {
        Event::listen(CoreAdminMenuRegistered::class, function($menu) {
            $menu->add(__('seo::menu.seo.index'), [
                'parent' => $menu->system->id
            ])->nickname('seo_root')->data('order', 9)->prepend('<i class="fab fa-keycdn"></i>');

            $menu->add(__('seo::menu.pre-redirect.index'), [
                'parent' => $menu->seo_root->id
            ])->nickname('seo_pre_redirect')->data('order', 9)->prepend('<i class=" fab fa-telegram-plane"></i>');

            $menu->add(__('seo::menu.error-redirect.index'), [
                'parent' => $menu->seo_root->id
            ])->nickname('seo_error_redirect')->data('order', 9)->prepend('<i class="fas fa-holly-berry"></i>');

            event(SeoAdminMenuRegistered::class, $menu);
        });
    }
}
