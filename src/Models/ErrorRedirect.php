<?php

namespace Module\Seo\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Module\Seo\Models\ErrorRedirect
 *
 * @property int $id
 * @property string $from_path
 * @property string $to_url
 * @property int|null $status_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\ErrorRedirect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\ErrorRedirect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\ErrorRedirect query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\ErrorRedirect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\ErrorRedirect whereFromPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\ErrorRedirect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\ErrorRedirect whereStatusCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\ErrorRedirect whereToUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Module\Seo\Models\ErrorRedirect whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ErrorRedirect extends Model
{
    protected $table = 'seo__error_redirects';

    protected $fillable = [
        'from_path',
        'to_url',
        'status_code',
    ];

    protected $casts = [
        'status_code' => 'int',
    ];

    public function getStatusCodeAttribute($value)
    {
        return $value ?: 302;
    }
}
