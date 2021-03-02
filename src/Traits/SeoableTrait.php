<?php

namespace Module\Seo\Traits;

use App;
use Illuminate\Support\Str;
use LaravelLocalization;
use Module\Seo\Models\Meta;
use Module\Seo\Models\Url;

trait SeoableTrait
{
    protected $seoableAttributes = [];

    abstract public function getUrl();

    public static function bootSeoableTrait()
    {
        static::deleting(function ($model) {
            !$model->seometa || $model->seometa->delete();

            foreach ($model->seourls as $seourl) {
                $seourl->delete();
            }
        });

        static::saved(function (self $model) {
            $model->saveSeoUrlAttribute();
            $model->saveSeoMetaAttribute();
        });
    }

    public function initializeSeoableTrait()
    {
        $this->fillable[] = 'seometa';
        $this->fillable[] = 'seourl';
        $this->fillable[] = 'url';
    }

    public function seoUrl(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        if (config('core.enable_translate')) {
            return $this
                ->morphOne(Url::class, 'urlable')
                ->where('locale', get_current_edit_locale());
        } else {
            return $this
                ->morphOne(Url::class, 'urlable');
        }
    }

    public function seoUrls(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Url::class, 'urlable');
    }

    public function seoMeta(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Meta::class, 'metable');
    }

    public function saveSeoMetaAttribute()
    {
        if (isset($this->seoableAttributes['seometa'])) {
            $value = $this->seoableAttributes['seometa'];

            if ($this->seometa) {
                $this->seometa->update($value);
            } else {
                $this->seoMeta()->create($value);
            }
        }
    }

    public function saveSeoUrlAttribute()
    {
        if (isset($this->seoableAttributes['seourl'])) {
            $value = $this->seoableAttributes['seourl'];

            $value['target_path'] = parse_url($this->getUrl(), PHP_URL_PATH);
            $value['request_path'] = $value['request_path'] ?? Str::slug($this->name);

            if ($this->seourl) {
                $this->seourl->update($value);
            } else {
                $this->seoUrl()->create($value);
            }
        }
    }

    public function setSeometaAttribute($value)
    {
        $this->seoableAttributes['seometa'] = $value;
    }

    public function setSeoUrlAttribute($value)
    {
        $this->seoableAttributes['seourl'] = $value;
    }

    public function getUrlAttribute()
    {
        if (method_exists($this, 'getUrl')) {
            $targetPath = ltrim(parse_url($this->getUrl(), PHP_URL_PATH), '/');

            $seoUrls = Url::where('target_path', $targetPath)->get();

            $urlSeo = $seoUrls->where('locale', App::getLocale())->first();
            if (!$urlSeo) {
                $urlSeo = $seoUrls->first();
            }

            $seoUrl = object_get($urlSeo, 'request_path', $targetPath);

            return LaravelLocalization::localizeURL($seoUrl);
        }

        return LaravelLocalization::localizeURL($this->slug);
    }

    public function setUrlAttribute($value)
    {
        $this->seoableAttributes['seourl']['request_path'] = $value;
    }
}
