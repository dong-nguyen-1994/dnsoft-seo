<?php

namespace Module\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use Dnsoft\Core\Support\Traits\CacheableTrait;
use Dnsoft\Core\Support\Traits\TranslatableTrait;
use Dnsoft\Media\Traits\HasMediaTrait;

/**
 * Module\Seo\Models\Meta
 *
 * @property int $id
 * @property string $metable_type
 * @property int $metable_id
 * @property array|null $title
 * @property array|null $description
 * @property array|null $keywords
 * @property string|null $robots
 * @property string|null $canonical
 * @property array|null $og_title
 * @property array|null $og_description
 * @property array|null $twitter_title
 * @property array|null $twitter_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $og_image
 * @property-read array $translations
 * @property mixed $twitter_image
 * @property-read \Illuminate\Database\Eloquent\Collection|\Dnsoft\Media\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $metable
 * @method static \Rinvex\Cacheable\EloquentBuilder|\Module\Seo\Models\Meta newModelQuery()
 * @method static \Rinvex\Cacheable\EloquentBuilder|\Module\Seo\Models\Meta newQuery()
 * @method static \Rinvex\Cacheable\EloquentBuilder|\Module\Seo\Models\Meta query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereCanonical($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereMetableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereMetableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereOgDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereOgTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereRobots($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereTwitterDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereTwitterTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\Meta whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Meta extends Model
{
    use CacheableTrait;
    use HasMediaTrait;
    use TranslatableTrait;

    protected $table = 'seo__metas';

    protected $fillable = [
        'title',
        'description',
        'keywords',
        'robots',
        'canonical',
        'og_title',
        'og_description',
        'twitter_title',
        'twitter_description',
        'og_image',
        'twitter_image',
    ];

    public $translatable = [
        'title',
        'description',
        'keywords',
        'og_title',
        'og_description',
        'twitter_title',
        'twitter_description',
    ];

    protected $medias = [
        'og_image',
        'twitter_image',
    ];

    public function metable()
    {
        return $this->morphTo();
    }

    public function setOgImageAttribute($value)
    {
        static::saved(function ($model) use ($value) {
            $model->syncMedia($value, 'og_image');
        });
    }

    public function getOgImageAttribute()
    {
        return $this->getFirstMedia('og_image');
    }

    public function setTwitterImageAttribute($value)
    {
        static::saved(function ($model) use ($value) {
            $model->syncMedia($value, 'twitter_image');
        });
    }

    public function getTwitterImageAttribute()
    {
        return $this->getFirstMedia('twitter_image');
    }
}
